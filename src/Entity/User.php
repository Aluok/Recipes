<?php
// src/App/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var \Date
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;
    //XXX add profile outside (Marmiton, ...)?

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
     * @param \App\Entity\Comment $commment
     *
     * @return User
     */
    public function addCommment(\App\Entity\Comment $commment)
    {
        $this->commments[] = $commment;

        return $this;
    }

    /**
     * Remove commment
     *
     * @param \App\Entity\Comment $commment
     */
    public function removeCommment(\App\Entity\Comment $commment)
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
     * @param \App\Entity\Rating $rating
     *
     * @return User
     */
    public function addRating(\App\Entity\Rating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \App\Entity\Rating $rating
     */
    public function removeRating(\App\Entity\Rating $rating)
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
     * @param \App\Entity\Recipe $recipe
     *
     * @return User
     */
    public function addRecipe(\App\Entity\Recipe $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \App\Entity\Recipe $recipe
     */
    public function removeRecipe(\App\Entity\Recipe $recipe)
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

    /**
     * Add comment
     *
     * @param \App\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\App\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \App\Entity\Comment $comment
     */
    public function removeComment(\App\Entity\Comment $comment)
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
}
