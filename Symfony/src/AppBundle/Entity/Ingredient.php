<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientRepository")
 */
class Ingredient
{
    const MESUREMENT_UNIT =
        array('choices.measurement.ml' => 'ml',
            'choices.measurement.dl' => 'dl',
            'choices.measurement.l' => 'l',
            'choices.measurement.g' => 'g',
            'choices.measurement.unit' => 'unit',
            'choices.measurement.coffee_spoon' => 'coffee spoon',
        );

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="quantityUnit", type="string", length=255)
     */
    private $quantityUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var object
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="ingredients", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="recipe_slug", referencedColumnName="slug", nullable=false),
     *      @ORM\JoinColumn(name="recipe_lang", referencedColumnName="language", nullable=false)
     * })
     **/
    private $recipe;

    /**
     * @var string
     *
     * @ORM\Column(name="recipe_lang", type="string", length=4)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="recipe_slug", type="string", length=255)
     */
    private $recipe_slug;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Constraints\NotBlank());
        $metadata->addPropertyConstraint('quantity', new Constraints\NotBlank());
        $metadata->addPropertyConstraint('quantity', new Constraints\Type(
            array("type" => 'integer')
        ));
        $metadata->addPropertyConstraint('quantityUnit', new Constraints\NotBlank());
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Ingredient
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set quantityUnit
     *
     * @param integer $quantityUnit
     *
     * @return Ingredient
     */
    public function setQuantityUnit($quantityUnit)
    {
        if (! in_array($quantityUnit, self::MESUREMENT_UNIT)) {
            throw new InvalidArgumentException(
                "The unit of the quantity needs to be in the allowed value"
            );
        }
        $this->quantityUnit = $quantityUnit;

        return $this;
    }

    /**
     * Get quantityUnit
     *
     * @return int
     */
    public function getQuantityUnit()
    {
        return $this->quantityUnit;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Ingredient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return Ingredient
     */
    public function setRecipe(\AppBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \AppBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Ingredient
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set recipeSlug
     *
     * @param string $recipeSlug
     *
     * @return Ingredient
     */
    public function setRecipeSlug($recipeSlug)
    {
        $this->recipe_slug = $recipeSlug;

        return $this;
    }

    /**
     * Get recipeSlug
     *
     * @return string
     */
    public function getRecipeSlug()
    {
        return $this->recipe_slug;
    }
}
