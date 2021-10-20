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
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    protected $user;
    protected $category;
    protected $product;

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
     * @Route("/admin_14A1789", name="admin")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(): Response
    {
        // you can also redirect to different pages depending on the current user
        if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }
        $users = $this->UserRepository->findAll();
        return $this->render('bundle\EasyAdminBundle\welcome.html.twig', [
            'countAllUsers' => $this->UserRepository->countAllUsers(),
            'users' => $users,

        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Pizza Mama');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('category', 'fa fa-user', Category::class);
        // yield MenuItem::linkToCrud('Product', 'fa fa-user', Product::class);
        // yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
