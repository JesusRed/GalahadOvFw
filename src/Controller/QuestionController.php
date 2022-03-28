<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Environment;

class QuestionController extends AbstractController
{
    private $logger;
    private $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

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
    public function show($anywordhere, MarkdownHelper $markdownHelper, HubInterface $sentryHub)
    {
        //dump($this->getParameter('cache.adapter'));
        //dump($isDebug);
        dump($sentryHub->getClient());
        if ($this->isDebug) {
            $this->logger->info('We are in debug mode!');
        }
        throw new \Exception('bad stuff happened!');

        $answers = [
            'Fear is a tool. When that light hits the `sky`, it’s not just a call. It’s a warning. For them. 🦇',
            'I can take care of myself. 🐱‍👤',
            'Get out of here or that suit’s gonna be full of blood. 🤣',
        ];

        $questionText = 'I\'ve been turned into a cat, any thoughts on how to turn back? While I\'m **adorable**, I don\'t really care for cat food.';

        $parsedQuestionText = $markdownHelper->parse($questionText);

        //dump($cache);
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