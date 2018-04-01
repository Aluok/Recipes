<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="author", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     ** @ORM\ManyToOne(targetEntity="Comment", inversedBy="responses")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $responseTo;

    /**
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="responseTo")
     */
    private $responses;

    /**
     * @var Recipe
     *
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="comments")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="recipe_slug", referencedColumnName="slug", nullable=false),
     *      @ORM\JoinColumn(name="recipe_lang", referencedColumnName="language", nullable=false)
     * })
     */
    private $recipe;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdatedDate", type="datetime", nullable=true)
     */
    private $lastUpdatedDate;


    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Comment
     */
    public function setAuthor($author): Comment
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
     */
    public function setDate($date): Comment
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * Set responseTo
     *
     * @param integer $responseTo
     *
     * @return Comment
     */
    public function setResponseTo($responseTo): Comment
    {
        $this->responseTo = $responseTo;

        return $this;
    }

    /**
     * Get responseTo
     *
     * @return int
     */
    public function getResponseTo(): int
    {
        return $this->responseTo;
    }

    /**
     * Set recipe
     *
     * @param Recipe $recipe
     *
     * @return Comment
     */
    public function setRecipe($recipe): Comment
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return Recipe
     */
    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text): Comment
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Set lastUpdatedDate
     *
     * @param \DateTime $lastUpdatedDate
     *
     * @return Comment
     */
    public function setLastUpdatedDate($lastUpdatedDate): Comment
    {
        $this->lastUpdatedDate = $lastUpdatedDate;

        return $this;
    }

    /**
     * Get lastUpdatedDate
     *
     * @return \DateTime
     */
    public function getLastUpdatedDate(): \DateTime
    {
        return $this->lastUpdatedDate;
    }

    /**
     * Add response
     *
     * @param Comment $response
     *
     * @return Comment
     */
    public function addResponse(Comment $response): Comment
    {
        $this->responses[] = $response;

        return $this;
    }

    /**
     * Remove response
     *
     * @param Comment $response
     */
    public function removeResponse(Comment $response)
    {
        $this->responses->removeElement($response);
    }

    /**
     * Get responses
     *
     * @return Comment[]
     */
    public function getResponses(): array
    {
        return $this->responses->toArray();
    }
}
