<?php

namespace App\Controller;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Environment;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(Environment $twigEnviroment)
    {
//      $html = $twigEnviroment->render('question/homepage.html.twig');
//      return new Response($html);
        return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/questions/{anywordhere}", name="app_question_show")
     */
    public function show($anywordhere, MarkdownParserInterface $markdownParser, CacheInterface $cache)
    {
        $answers = [
            'Fear is a tool. When that light hits the `sky`, it’s not just a call. It’s a warning. For them. 🦇',
            'I can take care of myself. 🐱‍👤',
            'Get out of here or that suit’s gonna be full of blood. 🤣',
        ];

        $questionText = 'I\'ve been turned into a cat, any thoughts on how to turn back? While I\'m **adorable**, I don\'t really care for cat food.';
        $parsedQuestionText = $cache->get('markdown_' . md5($questionText), function () use ($questionText, $markdownParser) {
            return $markdownParser->transformMarkdown($questionText);
        });

        dump($cache);
        //dd($markdownParser);
        //dump($this);

        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $anywordhere)),
            'questionText' => $parsedQuestionText,
            'answers' => $answers,
        ]);

//        return new Response(sprintf(
//            'A future page right below "%s" !',
//            ucwords(str_replace('-', ' ', $anywordhere))
//        ));
    }
}