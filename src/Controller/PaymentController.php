<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use Stripe\Checkout\Session;
use App\Service\Cart\CartService;
use Symfony\Component\Mime\Email;
use App\Repository\ProductRepository;
use Konekt\PdfInvoice\InvoicePrinter;
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
        EntityManagerInterface $entityManager
    ) {
        if ($request->attributes->get('email')) {
            // dd($cartService->getTotal());
            $order = new Order();

            $order->setPseudo1($request->attributes->get('pseudo'));
            // $order->setEmail($request->attributes->get('email'));
            $order->setPayedAt(new \DateTimeImmutable());
            $order->setAmount($cartService->getTotal());
            $entityManager->persist($order);
            $entityManager->flush();

            $size = 'A8';
            $currency = '€';
            $language = 'fr';

            $order = new InvoicePrinter($size, $currency, $language);
            // $order->setLogo('.\images\logo\logo.png', 20, 20);
            $order->setColor('#007fff');
            $order->setType('Simple Invoice');
            $order->setReference('INV-55033645');
            $order->setDate(date('d m Y', time()));
            $order->setFrom([
                'Société',
                'Pizza-Mama',
                '3 rue des pizza Italienne',
                'Paris - 75006',
            ]);
            $order->setTo(['Purchaser Name', '', '']);
            $order->addItem(
                'Pizza margherita',
                'supplement',
                6,
                0,
                580,
                0,
                3480
            );
            $order->addItem('Pizza Funghi', 'supplement', 4, 0, 645, 0, 2580);
            $order->addTotal('Total', 9460);
            $order->addTotal('VAT 20%', 1986.6);
            $order->addTotal('Total payé', 11446.6, true);
            $order->addParagraph(
                "En cas d'itérrogation sur cette facture veuillez la présenter en caisse ! "
            );
            $order->setFooternote(
                'Pizza-Mama ~ 3 rue des pizza Italienne ~ Paris ~ 75006'
            );

            $order->render('invoice.pdf', 'D');
        }
        $cartService->deleteAll($session);
        return [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
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
}
