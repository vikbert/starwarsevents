<?php

namespace Yoda\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Yoda\UserBundle\Entity\User;
use Yoda\UserBundle\UserUtils;

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
        $form = $this->createFormBuilder()
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('password', 'repeated', array('type' => 'password'))
            ->getForm();

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

        $userEntity = $this->initializedNewUser($form->getData());

        $em = $this->getDoctrine()->getManager();
        $em->persist($userEntity);
        $em->flush();

        return true;
    }

    /**
     * @param array $data
     * @return User
     */
    private function initializedNewUser(array $data)
    {
        $utils = new UserUtils($this->container);

        $newUser = new User();
        $newUser->setUsername($data['username']);
        $newUser->setEmail($data['email']);
        $newUser->setIsActive(false);
        $newUser->setPassword($utils->encodePassword($newUser, $data['password']));

        return $newUser;
    }
}