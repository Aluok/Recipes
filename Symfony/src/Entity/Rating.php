<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="App\Repository\RatingRepository")
 */
class Rating
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
     * @var Recipe
     *
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="reviews")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="recipe_slug", referencedColumnName="slug", nullable=false),
     *      @ORM\JoinColumn(name="recipe_lang", referencedColumnName="language", nullable=false)
     * })
     */
    private $recipe;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ratings")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * Set recipe
     *
     * @param \stdClass $recipe
     *
     * @return Rating
     */
    public function setRecipe($recipe): Rating
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
     * Set rating
     *
     * @param integer $rating
     *
     * @return Rating
     */
    public function setRating($rating): Rating
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     *
     * @return Rating
     */
    public function setAuthor($author): Rating
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
     * Set text
     *
     * @param string $text
     *
     * @return Rating
     */
    public function setText($text): Rating
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Rating
     */
    public function setDate($date): Rating
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
}
