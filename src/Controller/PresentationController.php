<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
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
        ProductRepository $products
    ) {
        $id=0;
        $AllCategories = $categories->findAll();
        $AllProducts = $products->findAllAvailable();
        return [
            'categories' => $AllCategories,
            'AllProducts' => $AllProducts,
        //    $product = $products ->findOneById($id)
        ];
    }
}
