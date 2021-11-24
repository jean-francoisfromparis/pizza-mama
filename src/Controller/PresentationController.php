<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\OrderType;
use App\Service\Cart\CartService;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\classHasAttribute;
use function PHPUnit\Framework\objectHasAttribute;

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
     * @return array
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

    /**
     * Order
     * @Route("/presentation/order")
     * @Template
     */
    public function order(Request $request, CartService $cartService)
    {
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);
        $pseudo = '';
        $email = '';
        $items = $cartService->getFullCart();
        $arrayLength = count($items);
        // dd( $items[0]['quantity'] * $items[0]['product']->getPrice());
        $description = 'vous avez commandez ';
        foreach ($cartService->getFullCart() as $item) {
            $description .= "$item[quantity] $item[product] ~ ";
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $forms[] = $request->request->get('order');
            $pseudo = $forms[0]['pseudo'];
            if ($forms[0]['email']) {
                $email = $forms[0]['email'];
            } else {
                $email = 'noreply@email.fr';
            }

            return $this->redirectToRoute('app_payment_checkout', [
                'pseudo' => $pseudo,
                'email' => $email,
                'description' => $description,
            ]);
        }
        // dd($cartService->getFullCart());
        // dd($description);
        return [
            'form' => $form->createView(),
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
        ];
    }
}
