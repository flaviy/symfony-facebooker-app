<?php

namespace App\Service;

use App\Exception\ServiceMethodCallException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Psr\Log\LoggerInterface;

class FbPageRequester
{
    private $facebook;
    private $fbAccessToken;
    private $logger;

    public function __construct($config, LoggerInterface $logger)
    {
        $this->facebook = new Facebook($config);
        $this->fbAccessToken = $this->facebook->getApp()->getAccessToken();
        $this->logger = $logger;
    }

    /**
     * @param $name
     * @return null
     */
    public function getFbPageId($name)
    {
        try {
            $pageInfo = $this->facebook
                ->get('/' . $name, $this->fbAccessToken)
                ->getDecodedBody();
            return $pageInfo['id'] ? $pageInfo['id'] : null;
        } catch (FacebookSDKException $ex) {
            $this->logger->debug($ex->getMessage(), $ex->getTrace());
           return null;
        }
    }

    /**
     * @param $pageId
     * @return array
     * @throws ServiceMethodCallException
     */
    public function getFbPageFeedAndComments($pageId)
    {
        $result = [];

        try {
            $feeds = $this->facebook->get('/' . $pageId . '/feed?limit=100&fields=created_time,from,id,message',
                $this->fbAccessToken)
                ->getDecodedBody();
            if (!empty($feeds['data'])) {
                foreach ($feeds['data'] as $feed) {
                    $comments = $this->getFbComments($feed['id']);
                    $result[] = [
                        'created_time' => new \DateTime($feed['created_time']),
                        'text' => isset($feed['message']) ? $feed['message'] : '',
                        'id' => $pageId,
                        'author' => isset($feed['from']['name']) ? $feed['from']['name'] : '',
                        'comments' => $comments['comments'],
                        'count_comments' => $comments['total_count'],
                        'count_likes' => $this->getCountLikes($feed['id'])
                    ];
                }
            }

        } catch (FacebookSDKException $ex) {
            $this->logger->debug($ex->getMessage(), $ex->getTrace());
            throw new ServiceMethodCallException('Facebook API error');
        }
        return $result;
    }

    /**
     * @param $feedId
     * @return array
     * @throws FacebookSDKException
     */
    public function getFbComments($feedId)
    {
        $comments = $this->facebook->get('/' . $feedId . '/comments?summary=true&order=reverse_chronological&fields=created_time,from,id,message',
            $this->fbAccessToken)->getDecodedBody();

        $return = [
            'total_count' => 0,
            'comments' => []
        ];
        if(!empty($comments['data'])) {
            $return['comments'] = $comments['data'];
        }
        if(!empty($comments['summary']['total_count'])) {
            $return['total_count'] = $comments['summary']['total_count'];
        }
        return $return;
    }

    /**
     * @param $feedId
     * @return int
     * @throws FacebookSDKException
     */
    public function getCountLikes($feedId)
    {
        $likes = $this->facebook->get('/' . $feedId . '/likes?summary=true',
            $this->fbAccessToken)->getDecodedBody();
        if(!empty($likes['summary']['total_count'])) {
            return $likes['summary']['total_count'];
        }
        return 0;
    }

}