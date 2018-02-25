<?php

namespace App\Controller;

use App\Exception\ServiceMethodCallException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FbComment;
use App\Entity\FbFeed;
use App\Service\FbPageRequester;

class FbPagesController extends AbstractController
{
    /**
     * @Route("/", name = "app_home")
     * @return Response
     */
    public function index()
    {
        return $this->render('fb_pages/index.html.twig');
    }

    /**
     * @Route("check-fb-page-posts", name="app_check_posts", methods={"POST"})
     * @param FbPageRequester $fbPageRequester
     * @param Request $request
     * @return JsonResponse
     */
    public function requestFbPagePosts(FbPageRequester $fbPageRequester, Request $request)
    {
        $inputValue = $request->get('inputValue');
        if(!$inputValue) {
            return $this->addJsonError('Empty Input Value');
        }

        $pageId = $fbPageRequester->getFbPageId($inputValue);
        if(!$pageId) {
            return $this->addJsonError('Fb page not found');
        }
        $repository = $this->getDoctrine()->getRepository(FbFeed::class);
        $feeds = $repository->findBy(['fbPageId' => $pageId]);

        if(empty($feeds)) {
            try {
                $feedsWithComments = $fbPageRequester->getFbPageFeedAndComments($pageId);
            } catch (ServiceMethodCallException $ex) {
                return $this->addJsonError($ex->getMessage());
            }
            if (!empty($feedsWithComments)) {
                $this->saveFeedsWithComments($feedsWithComments);
                $feeds = $repository->findBy(['fbPageId' => $pageId]);
            }
        }
        $response = [];
        if(!empty($feeds)) {
            foreach($feeds as $feed) {
                $response[] = [
                    'author' => $feed->getAuthor(),
                    'text' => $feed->getText(),
                    'count_likes' => $feed->getCountLikes(),
                    'created_time' => $feed->getCreatedTime()->format('Y-m-d H:i'),
                    'count_comments' => $feed->getCountComments(),
                    //'comments' => $feed->getFbComments()->getValues()
                ];
            }
        }

        return new JsonResponse($response);
    }

    /**
     * @param $error
     * @return JsonResponse
     */
    protected function addJsonError($error)
    {
        return new JsonResponse(['error' => $error]);
    }

    /**
     * @param $feedsWithComments
     */
    protected function saveFeedsWithComments($feedsWithComments): void
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($feedsWithComments as $feed) {
            $fbFeed = new FbFeed();
            $fbFeed->setAuthor($feed['author']);
            $fbFeed->setFbPageId($feed['id']);
            $fbFeed->setCountComments($feed['count_comments']);
            $fbFeed->setCountLikes($feed['count_likes']);
            $fbFeed->setCreatedTime($feed['created_time']);
            $fbFeed->setText($feed['text']);
            $em->persist($fbFeed);

            if (!empty($feed['comments'])) {
                foreach ($feed['comments'] as $comment) {
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
    }
}