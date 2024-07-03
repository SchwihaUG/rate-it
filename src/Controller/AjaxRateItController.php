<?php

namespace cgoIT\rateit\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use cgoIT\rateit\RateIt;
use Contao\CoreBundle\Framework\ContaoFramework;

class AjaxRateItController extends AbstractController {
    private $framework;

    public function __construct(ContaoFramework $framework) {
        $this->framework = $framework;
    }

    /**
     * Handles rating requests.
     *
     * @return JsonResponse
     *
     * @Route("/rateit", name="ajax_rateit", defaults={"_scope" = "frontend", "_token_check" = false})
     */
    public function ajaxAction() {
        $this->framework->initialize();

        $controller = new RateIt();

        $response = $controller->doVote();
        $response->send();

        return new Response(null);
    }
}
