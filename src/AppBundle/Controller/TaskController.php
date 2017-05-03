<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\MbTask;
use AppBundle\Entity\MbTag;

use AppBundle\Form\MbTaskType;
use AppBundle\Form\MbTagType;


class TaskController extends Controller
{
    /**
     * @Route("/task", name="task")
     */
    public function formAction(Request $request)
    {
        $task = new MbTask();

        $tag = new MbTag();
        $tag->setName('tag');
        $task->getTags()->add($tag);

        $tag = new MbTag();
        $tag->setName('tag');
        $task->getTags()->add($tag);

        $form = $this->get('form.factory')->create(MbTaskType::class, $task);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            
            if($form->isValid())
            {
                return $this->redirectToRoute('homepage');
            }
        }

        // replace this example code with whatever you need
        return $this->render('default/task.html.twig', [
            'form' => $form->createView(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
