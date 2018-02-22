<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class FbPagesController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function index()
    {
        return new Response('Hello! This is my first Symfony 4 page!');
    }

    /**
     * @Route("/show/{name}")
     * @param $name
     * @return Response
     */
    public function show($name)
    {
        return new Response('This is '.$name);
    }
}