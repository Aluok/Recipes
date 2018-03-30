<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $recipes = $em->getRepository('AppBundle:Recipe')->findByFinished(1);

        foreach ($recipes as $recipe) {
            $score = 0;
            $reviews = $recipe->getReviews();
            if (count($reviews) == 0) {
                $rating = 0;
            } else {
                foreach ($reviews as $rating) {
                    $score += $rating->getRating();
                }
                $rating = $score / count($reviews);
            }
            if ($rating >= 2 && count($reviews) >= 4) {
                $recipe->setPublished(true);
            } else {
                $recipe->setPublished(false);
            }
            $recipe->setRating($rating);
            $output->writeln($recipe->getTitle() . ' : ' . $rating . '   ');
            $em->persist($recipe);
        }
        $em->flush();

    }
}
