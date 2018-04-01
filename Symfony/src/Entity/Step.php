<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Step
 *
 * @ORM\Table(name="step")
 * @ORM\Entity(repositoryClass="App\Repository\StepRepository")
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
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     */
    private $image;

    /**
     * Bidirectionnal - One Recipe has many steps. OWNER SIDE
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="steps", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="recipe_slug", referencedColumnName="slug", nullable=false),
     *      @ORM\JoinColumn(name="recipe_lang", referencedColumnName="language", nullable=false)
     * })
     */
    private $recipe;

    /**
     * @param ClassMetadata $metadata
     * @throws \Symfony\Component\Validator\Exception\MissingOptionsException
     * @throws \Symfony\Component\Validator\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('text', new Constraints\NotBlank());
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
     * Set text
     *
     * @param string $text
     *
     * @return Step
     */
    public function setText($text): Step
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
     * Set image
     *
     * @param \stdClass $image
     *
     * @return Step
     */
    public function setImage($image): Step
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * Set recipe
     *
     * @param Recipe $recipe
     *
     * @return Step
     */
    public function setRecipe(Recipe $recipe): Step
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
}
