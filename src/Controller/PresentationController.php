<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * PresentationController
 */
class PresentationController extends AbstractController
{
    /**
     * @Route("/")
     * @Template
     * @return     array
     */
    public function index(): array
    {
        return [];
    }

    /**
     * @Route("/presentation")
     * @Template
     * @return                 array
     */
    public function presentation(
        CategoryRepository $categories,
        ProductRepository $products,
        CartService $cartService
    ) {
        $id = 0;
        $AllCategories = $categories->findAll();
        $AllProducts = $products->findAllAvailable();
        return [
            'categories' => $AllCategories,
            'AllProducts' => $AllProducts,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
        ];
    }

    /**
     * @Route("/presentation/add/{id}", name="cart_add")
     * @return void
     */
    public function add($id, CartService $cartService)
    {
        $cartService->add($id);
        return $this->redirectToRoute('app_presentation_presentation');
    }

    /**
     * Remove a product from the cart
     * @Route("/presentation/remove/{id}", name="cart_remove")
     * @return void
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute('app_presentation_presentation');
    }
}
