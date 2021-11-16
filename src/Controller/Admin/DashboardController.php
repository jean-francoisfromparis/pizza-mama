<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

/**
 * DashboardController
 */
class DashboardController extends AbstractDashboardController
{
    protected $user;
    protected $category;
    protected $product;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        UserRepository $user,
        CategoryRepository $category,
        ProductRepository $product
    ) {
        $this->UserRepository = $user;
        $this->CategoryRepository = $category;
        $this->ProductRepository = $product;
    }

    /**
     * Index
     *
     * @Route("/admin_14A1789",              name="admin")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function index(): Response
    {
        // you can also redirect to different pages depending on the current user
        if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }
        $countUsersByDates = [];
        $resultats = $this->UserRepository->findTenLastUsers();
        $countUsersByDates = $this->UserRepository->countUsersByDate();
        $dates = [];
        $count = [];
        foreach ($countUsersByDates as $countUsersByDate) {
            $dates[] = $countUsersByDate['userByDate'];
            $count[] = $countUsersByDate['count'];
        }

        // $count = ;
        return $this->render(
            'bundle\EasyAdminBundle\welcome.html.twig',
            [
            'countAllUsers' => $this->UserRepository->countAllUsers(),
            'resultats' => $resultats,
            'count' => json_encode($count),
            'dates' => json_encode($dates),
            ]
        );
    }

    /**
     * ConfigureDashboard
     *
     * @return Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle(
            '<div class="row my-3">
            <img src="../images/logo/logo.png" class="img-fluid" alt="Pizza Mama">
            </div>'
        );
    }

    /**
     * ConfigureMenuItems
     *
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard(
            'Tableau de bord',
            'fas fa-user-cog my-5'
        )->setCssClass('d-block');
        yield MenuItem::linkToCrud(
            'Catégories',
            'fa fa-tags mb-5',
            Category::class
        );
        yield MenuItem::linkToCrud(
            'Produits',
            'fas fa-hamburger  mb-5',
            Product::class
        );
        yield MenuItem::linkToCrud(
            'Utilisateurs',
            ' fa fa-users  mb-5',
            User::class
        );
    }
}
