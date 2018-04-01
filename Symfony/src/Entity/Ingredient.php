<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
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
     * @var Recipe
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

    /**
     * @param ClassMetadata $metadata
     * @throws \Symfony\Component\Validator\Exception\MissingOptionsException
     * @throws \Symfony\Component\Validator\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Constraints\NotBlank());
        $metadata->addPropertyConstraint('quantity', new Constraints\NotBlank());
        $metadata->addPropertyConstraint('quantity', new Constraints\Type(
            array('type' => 'integer')
        ));
        $metadata->addPropertyConstraint('quantityUnit', new Constraints\NotBlank());
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Ingredient
     */
    public function setQuantity($quantity): Ingredient
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Set quantityUnit
     *
     * @param integer $quantityUnit
     *
     * @return Ingredient
     * @throws \InvalidArgumentException
     */
    public function setQuantityUnit($quantityUnit): Ingredient
    {
        if (! \in_array($quantityUnit, self::MESUREMENT_UNIT, false)) {
            throw new \InvalidArgumentException(
                'The unit of the quantity needs to be in the allowed value'
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
    public function getQuantityUnit(): int
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
    public function setName($name): Ingredient
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set recipe
     *
     * @param Recipe $recipe
     *
     * @return Ingredient
     */
    public function setRecipe(Recipe $recipe = null): Ingredient
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
     * Set language
     *
     * @param string $language
     *
     * @return Ingredient
     */
    public function setLanguage($language): Ingredient
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

    /**
     * Set recipeSlug
     *
     * @param string $recipeSlug
     *
     * @return Ingredient
     */
    public function setRecipeSlug($recipeSlug): Ingredient
    {
        $this->recipe_slug = $recipeSlug;

        return $this;
    }

    /**
     * Get recipeSlug
     *
     * @return string
     */
    public function getRecipeSlug(): string
    {
        return $this->recipe_slug;
    }
}
