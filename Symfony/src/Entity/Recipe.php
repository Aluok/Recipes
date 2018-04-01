<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */
class Recipe
{
    const NB_RECIPE_PAGE = 10;

    const CATEGORIES = array(
        'choices.category.breakfast' => 'breakfast',
        'choices.category.lunch' => 'lunch',
        'choices.category.diner' => 'diner',
        'choices.category.snacks' => 'snacks'
    );
    /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="recipe", cascade={"persist", "remove"})
     * @var ArrayCollection
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
    * @ORM\Column(name="category", type="string", length=255, nullable=true)
    */
    private $category;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recipes")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time")
     */
    private $duration;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float", nullable=true)
     */
    private $rating;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var ArrayCollection
     * Bidirectionnal - One Recipe has many reviews. INVERSE SIDE
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="recipe", cascade={"persist", "remove"})
     */
    private $reviews;

    /**
     * @var bool
     *
     * @ORM\Column(name="isFinished", type="boolean")
     */
    private $finished;

    /**
     * @var bool
     *
     * @ORM\Column(name="isPublished", type="boolean")
     */
    private $published;

    /**
     * @var ArrayCollection
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="recipe", cascade={"remove"})
     * @ORM\JoinColumn(name="comments_id", nullable=true)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=4)
     */
    private $language;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->ingredients = new ArrayCollection();

        $this->setFinished(false)
            ->setPublished(false);
    }

    /**
     * @param ClassMetadata $metadata
     * @throws ConstraintDefinitionException
     * @throws InvalidOptionsException
     * @throws MissingOptionsException
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new Constraints\NotBlank());
        $metadata->addPropertyConstraint('title', new Constraints\Length(['min' => 3, 'max' => 150]));
        $metadata->addPropertyConstraint('title', new Constraints\Regex([
            'pattern' => '#[a-zA-Z]{3,150}#',
            'message' => 'This value should contain a title of 3 to 15 characters (a-z)',
        ]));
        $metadata->addPropertyConstraint('category', new Constraints\Choice(array(
            'choices' => self::CATEGORIES,
            'message' => 'Choose a valid category.',
            'multiple' => false,
        )));
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->slug;
    }

    /**
     * Get ingredients
     *
     * @return Ingredient[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients->toArray();
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Recipe
     */
    public function setCategory($category): Recipe
    {
        if (\in_array($category, self::CATEGORIES, false)) {
            $this->category = $category;
        } else {
            $this->category = null;
        }

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Recipe
     */
    public function setAuthor(User $author): Recipe
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
     * Generate slug
     *
     * @return Recipe
     */
    public function generateSlug(): Recipe
    {
        $this->slug = preg_replace('/ /', '_', $this->title . ' by ' . $this->author);
        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
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
    public function setDuration($duration): Recipe
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime
     */
    public function getDuration(): \DateTime
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
    public function setRating($rating): Recipe
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Recipe
     */
    public function setDate($date): Recipe
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
     * Get date timmestamp
     *
     * @return int
     */
    public function getDateTimestamp(): int
    {
        return $this->date->getTimestamp();
    }


    /**
     * Set reviews
     *
     * @param \stdClass $reviews
     *
     * @return Recipe
     */
    public function setReviews($reviews): Recipe
    {
        $this->reviews = $reviews;

        return $this;
    }

    /**
     * Get reviews
     *
     * @return Rating[]
     */
    public function getReviews(): array
    {
        return $this->reviews->toArray();
    }

    /**
     * Set isFinished
     *
     * @param boolean $finished
     *
     * @return Recipe
     */
    public function setFinished($finished): Recipe
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get isFinished
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * Set isPublished
     *
     * @param boolean $published
     *
     * @return Recipe
     */
    public function setPublished($published): Recipe
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * Add step
     *
     * @param Step $step
     *
     * @return Recipe
     */
    public function addStep(Step $step): Recipe
    {
        $step->setRecipe($this);
        $this->steps->add($step);

        return $this;
    }

    /**
     * Remove step
     *
     * @param Step $step
     */
    public function removeStep(Step $step)
    {
        $this->steps->removeElement($step);
    }

    /**
     * Get steps
     *
     * @return Step[]
     */
    public function getSteps(): array
    {
        return $this->steps->toArray();
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Recipe
     */
    public function addComment(Comment $comment): Recipe
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comments->toArray();
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Recipe
     */
    public function setTitle($title): Recipe
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
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
    public function setSlug($slug): Recipe
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
    public function setViews($views): Recipe
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * Add ingredient
     *
     * @param Ingredient $ingredient
     *
     * @return Recipe
     */
    public function addIngredient(Ingredient $ingredient): Recipe
    {
        $ingredient->setRecipe($this);
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param Ingredient $ingredient
     */
    public function removeIngredient(Ingredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Add review
     *
     * @param Rating $review
     *
     * @return Recipe
     */
    public function addReview(Rating $review): Recipe
    {
        $this->reviews[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param Rating $review
     */
    public function removeReview(Rating $review)
    {
        $this->reviews->removeElement($review);
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Recipe
     */
    public function setLanguage($language): Recipe
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }
}
