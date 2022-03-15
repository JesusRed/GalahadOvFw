<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('What a nightmare!');
    }

    /**
     * @Route("/questions/{anywordhere}")
     */
    public function show($anywordhere)
    {
        return new Response(sprintf(
            'A future page right below "%s" !',
            ucwords(str_replace('-', ' ', $anywordhere))
        ));
    }
}