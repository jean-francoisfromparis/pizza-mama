<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use App\Entity\Product;
use Stripe\Checkout\Session;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    /**
     * @Route("/checkout/{id}")
     * @Template
     */
    public function checkout($stripeSK, CartService $cartService, Request $request, User $user): Response
    {
        Stripe::setApiKey($stripeSK);
        $amount = $cartService->getTotal();
        $session = Session::create([
            'line_items' => [
                [
                    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                    'price' => null,
                    'quantity' => 1,
                    'currency' => 'EUR',
                    'amount' => $amount,
                    'name' => 'ok',

                ],
            ],
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => 'https://127.0.0.1:8000/success_url.html.twig',
            'cancel_url' => 'https://127.0.0.1:8000/cancel_url.html.twig',
        ]);

        return $this->redirect(
            $session->url,
            303,
            $user->getId(),
        );
    }

    /**
     * Successurl
     * @Route("/success-url/{id}")
     * @Template
     * @return Response
     */
    public function successUrl(User $user)
    {
        $pseudo = $user->getPseudo();
        return  [];
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
