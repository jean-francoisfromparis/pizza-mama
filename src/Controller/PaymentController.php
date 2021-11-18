<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Stripe\Checkout\Session;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    /**
     * @Route("/checkout/{pseudo}-{email}-{description}")
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
        } else { $email = 'test@email.com';}

        if ($request->attributes->get('description')) {
            $description = $request->attributes->get('description');
        } else { $description = 'Nous vous recercions pour votre commande chez Pizza-Mama';}


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
            "metadata" => ['name' => $pseudo ],
            'customer_email' => $email,
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => 'https://127.0.0.1:8000/success_url',
            'cancel_url' => 'https://127.0.0.1:8000/cancel_url',
        ]);

        return $this->redirect($session->url, 303);
    }

    /**
     * SuccessUrl
     * @Route("/success_url")
     * @Template
     * @return Response
     */
    public function successUrl(SessionInterface $session, CartService $cartService)
    {
        $cartService->deleteAll($session);
        return [];
    }

    /**
     * CancelUrl
     * @Route("/cancel_url")
     * @Template
     * @return Response
     */
    public function cancelUrl()
    {
        return [];
    }
}