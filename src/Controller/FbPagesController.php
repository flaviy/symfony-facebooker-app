<?php

namespace App\Controller;

use App\Entity\FbComment;
use App\Entity\FbFeed;
use App\Service\FbPageRequester;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FbPagesController extends AbstractController
{
    /**
     * @Route("/", name = "app_home")
     * @param FbPageRequester $fbPageRequester
     * @return Response
     * @throws \App\Exception\ServiceMethodCallException
     */
    public function index(FbPageRequester $fbPageRequester)
    {
        $pageInfo = $fbPageRequester->getFbPageInfo('kidsdoit');
        if (!empty($pageInfo)) {
            $em = $this->getDoctrine()->getManager();
            foreach ($pageInfo as $feed) {
                $fbFeed = new FbFeed();
                $fbFeed->setAuthor($feed['author']);
                $fbFeed->setFbPageId($feed['id']);
                $fbFeed->setCountComments($feed['count_comments']);
                $fbFeed->setCountLikes($feed['count_likes']);
                $fbFeed->setCreatedTime($feed['created_time']);
                $fbFeed->setText($feed['text']);
                $em->persist($fbFeed);

                if(!empty($feed['comments'])) {
                    foreach($feed['comments'] as $comment) {
                        $fbComment = new FbComment();
                        $fbComment->setFbFeed($fbFeed);
                        $fbComment->setCreatedTime($feed['created_time']);
                        $fbComment->setMessage($comment['message']);
                        $em->persist($fbComment);
                    }
                }
            }
            $em->flush();
            $em->clear();
            return $this->render('fb_pages/index.html.twig');
        }
        //return new Response('Hello! This is my first Symfony 4 page!');
    }

    /**
     * @Route("/check-page/{name}")
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

    /**
     * @Route("check-fb-page-posts", name="app_check_posts", methods={"POST"})
     */
    public function requestFbPagePosts()
    {
        return new JsonResponse([
            [
                'post' => 'Post body',
                'author' => 'Author 1',
                'date' => '12.12.2016',
                'count_likes' => 25
            ],
            [
                'post' => 'Post body 1',
                'author' => 'Author 2',
                'date' => '12.12.2017',
                'count_likes' => 12
            ],
        ]);
    }
}