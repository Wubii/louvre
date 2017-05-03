<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\MbOrder;

use AppBundle\Form\MbOrderType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $order = new MbOrder();

        $form = $this->get('form.factory')->create(MbOrderType::class, $order);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            
            if($form->isValid())
            {
                // $em = $this->getDoctrine()->getManager();
                // $em->persist($advert);
                // $em->flush();
                
                return $this->redirectToRoute('homepage');
            }
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
