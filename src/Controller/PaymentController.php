<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\OrderLine;
use Stripe\Checkout\Session;
use App\Service\Cart\CartService;
use Symfony\Component\Mime\Email;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Konekt\PdfInvoice\InvoicePrinter;
use App\Repository\OrderLineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    /**
     * @Route("/checkout/{pseudo}/{email}/{description}")
     * @Template
     */
    public function checkout(
        $stripeSK,
        CartService $cartService,
        ProductRepository $productRepository,
        // Product $product,
        Request $request
    ): Response {
        Stripe::setApiKey($stripeSK);
        $amount = $cartService->getTotal();
        $items = $cartService->getFullCart();

        $item = $items[0];
        if ($request->attributes->get('pseudo')) {
            $pseudo = $request->attributes->get('pseudo');
        }
        if ($request->attributes->get('email')) {
            $email = $request->attributes->get('email');
        } else {
            $email = 'test@email.com';
        }

        if ($request->attributes->get('description')) {
            $description = $request->attributes->get('description');
        } else {
            $description =
                'Nous vous recercions pour votre commande chez Pizza-Mama';
        }

        $session = Session::create([
            'line_items' => [
                [
                    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                    // 'price_data' => ['name' => $items['product']['name']],
                    'price' => null,
                    'quantity' => 1,
                    'currency' => 'EUR',
                    'amount' => $amount,
                    'name' => $pseudo,
                    'description' => $description,
                ],
            ],
            // "customer" => $pseudo,
            'metadata' => ['name' => $pseudo],
            'customer_email' => $email,
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            // 'success_url' => 'https://127.0.0.1:8000/success_url',
            // 'cancel_url' => 'https://127.0.0.1:8000/cancel_url',
            'success_url' => $this->generateUrl(
                'app_payment_successurl',
                ['pseudo' => $pseudo, 'email' => $email, 'amount' => $amount],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'cancel_url' => $this->generateUrl(
                'app_payment_cancelurl',
                ['name' => $pseudo],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
        ]);

        return $this->redirect($session->url, 303);
    }

    /**
     * SuccessUrl
     * @Route("/success_url/{pseudo}/{email}/{amount}")
     * @Template
     */
    public function successUrl(
        SessionInterface $session,
        CartService $cartService,
        Request $request,
        MailerInterface $mailer,
        OrderRepository $orderRepository,
        OrderLineRepository $orderLineRepository,
        // OrderLine $orderLine,
        EntityManagerInterface $entityManager
    ) {
        if ($request->attributes->get('email')) {
            $email = $request->attributes->get('email');
            $order = new Order();
            // $order->setEmail($email);
            $order->setPseudo1($request->attributes->get('pseudo'));
            $order->setPayedAt(new \DateTimeImmutable());
            $order->setAmount($cartService->getTotal());
            $entityManager->persist($order);
            $entityManager->flush();
            // $lastInsertedOrder =$orderRepository->findLastInserted();
            // $id =  $lastInsertedOrder[0];
            // dd($id->getId());
            $items = $cartService->getFullCart();
            $length = count($items);
            $em = $this->getDoctrine()->getManager();
            for ($i = 0; $i < $length; $i++) {
                $orderLine = (new OrderLine())
                ->setOrderLine($order)
                ->setProductName($items[$i ]['product']->getName())
                ->setPrice($items[$i ]['product']->getPrice())
                ->setQuantity($items[$i ]['quantity']);
                $em->persist($orderLine);
                $em->flush();
            }
        }

        $id = $order->getId();

        $cartService->deleteAll($session);
        // return $this->redirectToRoute('');
        return [
            'id' => $id,
           'order' => $order,
           'orderLines' =>  $orderLineRepository->findAllById('01FNA35SRYSWY746JRWN9SXBQN'),
            'email' => $request->attributes->get('email'),
            'pseudo' => $request->attributes->get('pseudo'),
        ];
    }

    /**
     * CancelUrl
     * @Route("/cancel_url")
     * @Template
     * @return Response
     */
    public function cancelUrl(CartService $cartService)
    {
        return [];
    }

    /**
     * invoice
     * @Route("invoice/{pseudo}/{email}/{id}")
     * @Template
     *
     */
    public function invoice(
        SessionInterface $session,
        CartService $cartService,
        Request $request,
        MailerInterface $mailer
    ) {

        $items = $cartService->getFullCart();
        $size = 'A8';
        $currency = '€';
        $language = 'fr';
        $discount = false;
        $i = 0;
        $amount = $cartService->getTotal();
        $price =  $items[0]['quantity'] * ($items[0]['product']->getPrice()) * 0.01;
        $order = new InvoicePrinter($size, $currency, $language);
        // $order->setLogo('.\images\logo\logo.png', 20, 20);
        $order->setColor('#007fff');
        $order->setType('Facture');
        $order->setReference('');
        $order->setDate(date('d m Y', time()));
        $order->setFrom([
            'Société',
            'Pizza-Mama',
            '3 rue des pizza Italienne',
            'Paris - 75006',
        ]);
        // dd( gettype($price));
        $order->setTo([$request->attributes->get('pseudo'), '', '']);
        $order->addItem($items[0]['product']->getName(), false, $items[0]['quantity'], 10, ($items[0]['product']->getPrice()) * 0.01, $discount, $price);
        $order->addTotal('Total', $amount);
        $order->addTotal('TVA 10%', $amount * 0.01 / (1 + 0.1));
        $order->addTotal('Total payé', $amount, true);
        $order->addParagraph(
            "En cas d'itérrogation sur cette facture veuillez la présenter en caisse ! "
        );
        $order->setFooternote(
            'Pizza-Mama ~ 3 rue des pizza Italienne ~ Paris ~ 75006'
        );
        $order->render('invoice.pdf', 'I');
        $cartService->deleteAll($session);
    }
}
