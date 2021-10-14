<?php

/**
 * This file controlls templates of the onboarding section.
 *
 * @author Jean-françois Lepante <jeanfrancois.lepante@gmail.com>
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Used to control the dashboard templates.
 *
 * @author Jean-françois Lepante <jeanfrancois.lepante@gmail.com>
 */
class DashboardController extends AbstractController
{
    /**
     * Dashboard template introduction
     *
     * @Route("/dashboard")
     * @Template
     */
    public function index()
    {
        return [];
    }
}
