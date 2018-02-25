<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FbCommentRepository")
 */
class FbComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $fbFeedId;

    /**
     * @ManyToOne(targetEntity="FbFeed", inversedBy="fbComments")
     * @JoinColumn(name="fb_feed_id", referencedColumnName="id")
     */
    private $fbFeed;


    /**
     * @ORM\Column(type="text", options={"collation" : "utf8mb4_unicode_ci"})
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdTime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFbFeedId()
    {
        return $this->fbFeedId;
    }

    /**
     * @param mixed $fbFeedId
     */
    public function setFbFeedId($fbFeedId): void
    {
        $this->fbFeedId = $fbFeedId;
    }

    /**
     * @return mixed
     */
    public function getFbFeed()
    {
        return $this->fbFeed;
    }

    /**
     * @param mixed $fbFeed
     */
    public function setFbFeed(FbFeed $fbFeed): void
    {
        $this->fbFeed = $fbFeed;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $text
     */
    public function setMessage($text): void
    {
        $this->message = $text;
    }

    /**
     * @return mixed
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param mixed $created
     */
    public function setCreatedTime($created): void
    {
        $this->createdTime = $created;
    }
}
