<?php

namespace RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="RecipeBundle\Repository\RecipeRepository")
 */
class Recipe
{
    /**
     * @var string
     *
     * @ORM\Column(name="ingredients", type="string", length=255)
     */
    private $ingredients;


   /**
    * @var string
    *
    * @ORM\Column(name="title", type="string", length=255)
    */
   private $title;

   /**
    * @var string
    *
    * @ORM\Column(name="category", type="string", length=255)
    */
   private $category;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recipes")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time")
     */
    private $duration;

    /**
     * @var decimal
     *
     * @ORM\Column(name="rating", type="decimal", nullable=true)
     */
    private $rating;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="reviews", type="object", nullable=true)
     */
    private $reviews;

    /**
     * @var bool
     *
     * @ORM\Column(name="isFinished", type="boolean")
     */
    private $isFinished;

    /**
     * @var bool
     *
     * @ORM\Column(name="isPublished", type="boolean")
     */
    private $isPublished;

    /**
     * Bidirectionnal - One Recipe has many steps. INVERSE SIDE
     * @ORM\OneToMany(targetEntity="Step", mappedBy="recipe", cascade={"persist", "remove"})
     */
    private $steps;

    /**
     * @var int
     *
     * @ORM\Column(name="viewed", type="integer")
     */
    private $views = 0;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="recipe", cascade={"remove"})
     * @ORM\JoinColumn(name="comments_id", nullable=true)
     */
    private $comments;

    public function __construct()
    {
      $this->steps = new ArrayCollection();
      $this->comments = new ArrayCollection();
      $this->setIsFinished(false)
        ->setIsPublished(false);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->slug;
    }

    /**
     * Set ingredients
     *
     * @param string $ingredients
     *
     * @return Recipe
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Get ingredients
     *
     * @return string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Recipe
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     *
     * @return Recipe
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \stdClass
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Recipe
     */
    public function generateSlug()
    {
        $this->slug = preg_replace("/ /i", "_", $this->title . " by " . $this->author);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     *
     * @return Recipe
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Recipe
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Recipe
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set reviews
     *
     * @param \stdClass $reviews
     *
     * @return Recipe
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;

        return $this;
    }

    /**
     * Get reviews
     *
     * @return \stdClass
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set isFinished
     *
     * @param boolean $isFinished
     *
     * @return Recipe
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * Get isFinished
     *
     * @return bool
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     *
     * @return Recipe
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return bool
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Add step
     *
     * @param \RecipeBundle\Entity\Step $step
     *
     * @return Recipe
     */
    public function addStep(\RecipeBundle\Entity\Step $step)
    {
        $this->steps[] = $step;

        return $this;
    }

    /**
     * Remove step
     *
     * @param \RecipeBundle\Entity\Step $step
     */
    public function removeStep(\RecipeBundle\Entity\Step $step)
    {
        $this->steps->removeElement($step);
    }

    /**
     * Get steps
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Add comment
     *
     * @param \RecipeBundle\Entity\Comment $comment
     *
     * @return Recipe
     */
    public function addComment(\RecipeBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \RecipeBundle\Entity\Comment $comment
     */
    public function removeComment(\RecipeBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Recipe
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Recipe
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }
}
