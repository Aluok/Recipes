<?php
namespace RecipeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use RecipeBundle\Entity\Recipe;

class UpdateRatingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('recipe:update:ratings')
            ->setDescription('Updates the ratings of allrecipe')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $recipes = $em->getRepository('RecipeBundle:Recipe')->findByIsFinished(1);

        $text = "";

        foreach ( $recipes as $recipe){
            $score = 0;
            $reviews = $recipe->getReviews();
            if (count($reviews) == 0)
                $rating = 0;
            else {
                foreach ($recipe->getReviews() as $rating){
                    $score += $rating->getRating();
                }
                $rating = $score / count($reviews);
            }
            if ($rating >= 2 )
                $recipe->setIsPublished(true);
            else
                $recipe->setIsPublished(false);

            $recipe->setRating($rating);
            $output->writeln($recipe->getTitle() . ' : ' . $rating . '   ');
            $em->persist($recipe);
        }
        $em->flush();

    }
}
