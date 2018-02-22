<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FbPagesController extends AbstractController
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
     * @Route("/check_page/{name}")
     * @param $name
     * @return Response
     */
    public function check($name)
    {
        $posts = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render('fb_pages/check.html.twig', [
            'name' => ucwords(str_replace('-', ' ', $name)),
            'posts' => $posts
        ]);
    }
}