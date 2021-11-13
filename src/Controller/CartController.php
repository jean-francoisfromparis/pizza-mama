<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * CartController
 */
class CartController extends AbstractController
{
    /**
     * @Route("/cart")
     * @Template
     * @return     array
     */
    public function cart(cartService $cartService)
    {
        return
        [
            'items' => $cartService->getFullCart(),
            'total' =>$cartService->getTotal(),
            ];
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     * @return void
     */
    public function add($id, CartService $cartService)
    {
        $cartService->add($id);
        return $this->redirectToRoute('app_cart_cart');
    }

    /**
     * Remove a product from the cart
     * @Route("/cart/remove/{id}", name="cart_remove")
     * @return void
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute('app_cart_cart');
    }
}
