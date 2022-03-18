<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
//      $html = $twigEnviroment->render('question/homepage.html.twig');
//      return new Response($html);
        return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/questions/{anywordhere}", name="app_question_show")
     */
    public function show($anywordhere)
    {
        $answers = [
            'Fear is a tool. When that light hits the sky, it’s not just a call. It’s a warning. For them. 🦇',
            'I can take care of myself. 🐱‍👤',
            'Get out of here or that suit’s gonna be full of blood. 🤣',
        ];

        dump($this);

        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $anywordhere)),
            'answers' => $answers,
        ]);

//        return new Response(sprintf(
//            'A future page right below "%s" !',
//            ucwords(str_replace('-', ' ', $anywordhere))
//        ));
    }
}