<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FbFeedRepository")
 */
class FbFeed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $fbPageId;


    /**
     * @ORM\Column(type="text", options={"collation" : "utf8mb4_unicode_ci"})
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="integer", length=4, nullable=false, options={"default" : 0})
     */
    private $countLikes;

    /**
     * @ORM\Column(type="integer", length=4, nullable=false, options={"default" : 0})
     */
    private $countComments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FbComment", mappedBy="fbFeed")
     */
    private $fbComments;

    /**
     * FbFeed constructor.
     */
    public function __construct()
    {
        $this->fbComments = new ArrayCollection();
    }

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
    public function getFbPageId()
    {
        return $this->fbPageId;
    }

    /**
     * @param mixed $fbPageId
     */
    public function setFbPageId($fbPageId): void
    {
        $this->fbPageId = $fbPageId;
    }


    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCountLikes()
    {
        return $this->countLikes;
    }

    /**
     * @param mixed $countLikes
     */
    public function setCountLikes($countLikes): void
    {
        $this->countLikes = $countLikes;
    }

    /**
     * @return mixed
     */
    public function getCountComments()
    {
        return $this->countComments;
    }

    /**
     * @param mixed $countComments
     */
    public function setCountComments($countComments): void
    {
        $this->countComments = $countComments;
    }

    /**
     * @return mixed
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param $createdTime
     */
    public function setCreatedTime($createdTime): void
    {
        $this->createdTime = $createdTime;
    }

    /**
     * @return Collection|FbComment[]
     */
    public function getFbComments()
    {
        return $this->fbComments;
    }
}
