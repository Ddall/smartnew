<?php

namespace AppBundle\Controller\Layout;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class LayoutController extends Controller {

    /**
     *
     * @Route("/render-navbar", name="back-render-top")
     */
    public function renderTopAction(Request $request) {

        return $this->render('AppBundle:layout:top.html.twig', array(

        ));

    }



    /**
     *
     * @Route("/render-left", name="back-render-left")
     */
    public function renderLeftAction(Request $request) {

        return $this->render('AppBundle:layout:left.html.twig', array(

        ));

    }

    /**
     *
     * @Route("/render-menu", name="back-render-menu")
     */
    public function renderMenuAction(Request $request) {


        return $this->render('AppBundle:layout:menu.html.twig',
            [
//                'typesPageSystem' => $typesPageSystem,
//                'modules' => $modules
            ]
        );

    }





}
