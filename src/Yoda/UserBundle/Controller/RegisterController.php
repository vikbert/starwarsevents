<?php

namespace Yoda\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Yoda\UserBundle\Entity\User;
use Yoda\UserBundle\UserUtils;
use Yoda\UserBundle\Form\RegisterFormType;

/**
 * Class RegisterController
 * @package Yoda\UserBundle\Controller
 */
class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template("UserBundle:Security:register.html.twig")
     *
     * @var Request $request
     * @return array
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $user->setUsername('Your_user_name');

        $form = $this->createForm(new RegisterFormType(), $user);

        if ($this->handleFormRequest($form, $request) === true) {
            return $this->redirect($this->generateUrl('login_form'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @param Form $form
     * @param Request $request
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function handleFormRequest(Form $form, Request $request)
    {
        $form->handleRequest($request);
        if (!$form->isValid()) {
            return false;
        }

        $userEntity = $this->initUser($form->getData());

        $em = $this->getDoctrine()->getManager();
        $em->persist($userEntity);
        $em->flush();

        return true;
    }

    /**
     * @param User $newUser
     * @return User
     */
    private function initUser(User $newUser)
    {
        $utils = new UserUtils($this->container);

        $newUser->setIsActive(false);
        $newUser->setPassword($utils->encodePassword($newUser, $newUser->getPassword()));

        return $newUser;
    }
}