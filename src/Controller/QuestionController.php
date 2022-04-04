<?php

namespace App\Controller;

use App\Entity\Question;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;
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
     * @Route("/questions/new")
     */
    public function new(EntityManagerInterface $entityManager)
    {
        $question = new Question();
        $question->setName('Missing pants')
            ->setAnywordhere('missing-pants-' . random_int(0, 1000))
            ->setQuestion(<<<EOF
Hi! So... I'm having a *weird* day. Yesterday, I cast a spell
to make my dishes wash themselves. But while I was casting it,
I slipped a little and I think `I also hit my pants with the spell`.
When I woke up this morning, I caught a quick glimpse of my pants
opening the front door and walking out! I've been out all afternoon
(with no pants mind you) searching for them.
Does anyone have a spell to call your pants back?
EOF
            );

        if (random_int(1, 10) > 2) {
            $question->setAskedAt(new \DateTimeImmutable(sprintf('-%d days', random_int(1, 100))));
        }

        $entityManager->persist($question);
        $entityManager->flush();

        //dd($question);

        return new Response(sprintf(
            'Well hallo! The shiny new question is id #%d, slug: %s',
            $question->getId(),
            $question->getAnywordhere()
        ));
    }

    /**
     * @Route("/questions/{anywordhere}", name="app_question_show")
     */
    public function show($anywordhere, MarkdownHelper $markdownHelper, HubInterface $sentryHub)
    {
        //dump($this->getParameter('cache.adapter'));
        //dump($isDebug);
        if ($this->isDebug) {
            $this->logger->info('We are in debug mode!');
        }

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