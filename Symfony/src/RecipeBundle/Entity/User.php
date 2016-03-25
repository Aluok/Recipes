<?php
// src/RecipeBundle/Entity/User.php

namespace RecipeBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="author")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="author")
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="author")
     */
    private $recipes;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->recipes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    /**
     * Add commment
     *
     * @param \RecipeBundle\Entity\Comment $commment
     *
     * @return User
     */
    public function addCommment(\RecipeBundle\Entity\Comment $commment)
    {
        $this->commments[] = $commment;

        return $this;
    }

    /**
     * Remove commment
     *
     * @param \RecipeBundle\Entity\Comment $commment
     */
    public function removeCommment(\RecipeBundle\Entity\Comment $commment)
    {
        $this->commments->removeElement($commment);
    }

    /**
     * Get commments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommments()
    {
        return $this->commments;
    }

    /**
     * Add rating
     *
     * @param \RecipeBundle\Entity\Rating $rating
     *
     * @return User
     */
    public function addRating(\RecipeBundle\Entity\Rating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \RecipeBundle\Entity\Rating $rating
     */
    public function removeRating(\RecipeBundle\Entity\Rating $rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Add recipe
     *
     * @param \RecipeBundle\Entity\Recipe $recipe
     *
     * @return User
     */
    public function addRecipe(\RecipeBundle\Entity\Recipe $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \RecipeBundle\Entity\Recipe $recipe
     */
    public function removeRecipe(\RecipeBundle\Entity\Recipe $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}
