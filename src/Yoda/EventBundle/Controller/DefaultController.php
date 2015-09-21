<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Template("EventBundle:Default:index.html.twig")
     * @param $count
     * @param $firstName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($count, $firstName)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('EventBundle:Event');

        $event = $repo->findOneBy(array(
            'name' => 'Rebellion Fundraiser Bake Sale!',
        ));

        return array(
            'name' => $firstName,
            'count' => $count,
            'event'=> $event,
        );
    }
}