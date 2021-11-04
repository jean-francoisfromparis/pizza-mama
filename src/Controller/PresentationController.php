<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * PresentationController
 */
class PresentationController extends AbstractController
{
    /**
     * @Route("/")
     * @template
     * @return     Response
     */
    public function index(): Response
    {
        return $this->render(
            'presentation/index.html.twig', [
            ]
        );
    }
}
