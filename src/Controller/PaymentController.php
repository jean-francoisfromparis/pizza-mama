<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Stripe\Stripe;

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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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
                    'price' => null,
                    'quantity' => 1,
                    'currency' => 'EUR',
                    'amount' => $amount,
                    'name' => $pseudo,
                    'description' => $description,
                ],
            ],
            'metadata' => ['name' => $pseudo],
            'customer_email' => $email,
            'payment_method_types' => ['card'],
            'mode' => 'payment',
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
        OrderLineRepository $orderLineRepository,
        EntityManagerInterface $entityManager
    ) {

        if ($request->attributes->get('email')) {
            $email = $request->attributes->get('email');
            $order = new Order();
            $order->setEmail($email);
            $order->setPseudo1($request->attributes->get('pseudo'));
            $order->setPayedAt(new \DateTimeImmutable());
            $order->setAmount($cartService->getTotal());

            $entityManager->persist($order);
            $entityManager->flush();

            // This part aim to record in database the order lines
            $items = $cartService->getFullCart();
            $length = count($items);
            $em = $this->getDoctrine()->getManager();
            for ($i = 0; $i < $length; $i++) {
                $orderLine = (new OrderLine())
                    ->setOrderLine($order)
                    ->setProductName($items[$i]['product']->getName())
                    ->setPrice($items[$i]['product']->getPrice())
                    ->setQuantity($items[$i]['quantity']);
                $em->persist($orderLine);
                $em->flush();
            }
            $orderLines = $orderLineRepository->findAllById($order);
            $id = $order->getId();
            $email = (new TemplatedEmail())
            ->from('pizze.mama.it@gmail.com')
            ->to($request->attributes->get('email'))
            ->subject('votre facture :'.date('d m Y', time()).$request->attributes->get('pseudo'))
            ->text('Veuillez trouver votre facture ci-joint')
            ->htmlTemplate('payment/email/email.html.twig')
            ->context([
                'id' => $id,
                'order' => $order,
                'orderLines' => $orderLines,
                'amount' => $request->attributes->get('amount'),
                'email1' => $request->attributes->get('email'),
                'pseudo' => $request->attributes->get('pseudo'),
            ]);

        $mailer->send($email);

        }

        $id = $order->getId();

        $orderLines = $orderLineRepository->findAllById($order);

        $cartService->deleteAll($session);
        // return $this->redirectToRoute('');
        return [
            'id' => $id,
            'order' => $order,
            'orderLines' => $orderLines,
            'amount' => $request->attributes->get('amount'),
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
  * orderLines
  *
  * @return void
  */
 public function orderLines(
     OrderLineRepository $orderLineRepository,
     OrderRepository $orderRepository
     )
 {

 }
}
