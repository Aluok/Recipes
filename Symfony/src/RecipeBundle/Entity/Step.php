<?php

namespace RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Step
 *
 * @ORM\Table(name="step")
 * @ORM\Entity(repositoryClass="RecipeBundle\Repository\StepRepository")
 */
class Step
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
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var \stdClass
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     */
    private $image;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="steps")
     * @ORM\JoinColumn(name="recipe_slug", referencedColumnName="slug")
     */
     private $recipe;

     /**
      *
      * @ORM\Column(name="step_order", type="integer", nullable=false)
      */
      private $order;

      /**
       * @ORM\OneToMany(targetEntity="Comment", mappedBy="step")
       */
      private $comments;

      public function __construct()
      {
        $this->comments = new ArrayCollection();
      }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->recipe_order;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Step
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set image
     *
     * @param \stdClass $image
     *
     * @return Step
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \stdClass
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set comments
     *
     * @param \stdClass $comments
     *
     * @return Step
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return \stdClass
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set recipe
     *
     * @param \stdClass $recipe
     *
     * @return Step
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \stdClass
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set order
     *
     * @param \int $order
     *
     * @return Step
     */
    public function setOrder(int $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add comment
     *
     * @param \RecipeBundle\Entity\Comment $comment
     *
     * @return Step
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
}
