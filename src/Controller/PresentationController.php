<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\OrderType;
use App\Data\SearchData;
use App\Entity\Comments;
use App\Form\SearchForm;
use App\Form\CommentsType;

use App\Service\Cart\CartService;
use App\Repository\ProductRepository;

use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\classHasAttribute;
use function PHPUnit\Framework\objectHasAttribute;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        CartService $cartService,
        Request $request
    ) {
        $data = new SearchData();

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $result = $products->search($data);

        // dd($form);
        $AllCategories = $categories->findAll();
        $AllProducts = $products->findAllAvailable();
        return [
            'results' => $result,
            'form' => $form->createView(),
            'categories' => $AllCategories,
            'AllProducts' => $AllProducts,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
        ];
    }

    /**
     * @Route("/gallery")
     * @Template
     * @return array
     */
    public function gallery(
        CategoryRepository $categories,
        ProductRepository $products,
        CartService $cartService,
        Request $request
    ) {
        $data = new SearchData();

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $result = $products->search($data);

        // dd($form);
        $AllCategories = $categories->findAll();
        $AllProducts = $products->findAllAvailable();
        return [
            'results' => $result,
            'form' => $form->createView(),
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
        return $this->redirectToRoute('app_presentation_gallery');
    }

    /**
     * Remove a product from the cart
     * @Route("/presentation/remove/{id}", name="cart_remove")
     * @return void
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute('app_presentation_gallery');
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

    /**
     * Comments page render
     * @Route("/presentation/commentaires")
     * @Template
     * @param  mixed $request
     * @return void
     */
    public function comments(Request $request)
    {
        $comment = new Comments();
        $form = $this -> createForm(CommentsType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $comment->setcreatedAt(new \DateTimeImmutable());

            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('message', 'Votre commentaire a été envoyé');
            return $this->redirectToRoute('app_presentation_presentation');
        }

        return [
            'form' =>$form->createView(),
            'title' => 'Créer un nouveau commentaire'
        ];
    }

    /**
     * showComments
     * @IsGranted("ROLE_USER", statusCode=404, message="Pour accéder à cette page vous devez être connecté")
     * @Route("/presentation/affichage_des_commentaires")
     * @Template
     * @return void
     */
    public function showComments(CommentsRepository $repo, UserInterface $user)
    {

        $email =$user->getUserIdentifier();
        $commentsByEmail = $repo->findByEmail($email);
        return [
            'email' => $email,
            'comments' => $commentsByEmail,
        ];
    }
}
