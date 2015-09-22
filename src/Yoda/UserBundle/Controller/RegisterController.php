<?php

namespace Yoda\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class RegisterController
 * @package Yoda\UserBundle\Controller
 */
class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template("UserBundle:Security:register.html.twig")
     */
    public function registerAction()
    {
        $form = $this->createFormBuilder()
            ->add('username', 'text')
            ->add('email', 'text')
            ->add('password', 'password')
            ->getForm();

        return array('form' => $form->createView());
    }
}