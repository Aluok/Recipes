<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Step
 *
 * @ORM\Table(name="step")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StepRepository")
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
     * Bidirectionnal - One Recipe has many steps. OWNER SIDE
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="steps", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="recipe_slug", referencedColumnName="slug")
     */
    private $recipe;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('text', new Constraints\NotBlank());
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
     * Set recipe
     *
     * @param \stdClass $recipe
     *
     * @return Step
     */
    public function setRecipe(Recipe $recipe)
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
}
