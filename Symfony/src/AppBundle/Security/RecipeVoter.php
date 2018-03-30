<?php
namespace AppBundle\Security;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\User;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RecipeVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        if (! in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        if (! $subject instanceof Recipe) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        //We know that subject is a recipe object thanks to the supports method
        $recipe = $subject;

        if (! $user instanceof User) {
            return $recipe->getIsPublished();
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($recipe, $user);
            case self::VIEW:
                return $this->canView($recipe, $user);
        }

            throw new \LogicException("This part should never be reached. Wrong attribute.");
    }

    private function canView(Recipe $recipe, User $user)
    {
        if ($this->canEdit($recipe, $user)) {
            return true;
        }

        return $recipe->getIsFinished();
    }

    private function canEdit(Recipe $recipe, User $user)
    {
        return $recipe->getAuthor() === $user;
    }
}
