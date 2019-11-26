<?php namespace Osky;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use Osky\Command;

/**
 * Author: Ashraf Kamarudin <ashrafkamarudin1995@gmail.com>
 */
class TimeCommand extends Command
{
    
    public function configure()
    {
        $this -> setName('reddit:search')
            -> setDescription('Search through subreddit post.')
            -> setHelp('This command allows you to search through reddit post...');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {

        $helper = $this->getHelper('question');
        $question1 = new Question('Provide a Subreddit name  : ');
        $question2 = new Question('Provide a Search Term: ');

        $subreddit = $helper->ask($input, $output, $question1);
        $searchInput = $helper->ask($input, $output, $question2);

        $this -> searchPost($input, $output, [
            'subreddit' => $subreddit,
            'search_term' => $searchInput
        ]);
    }
}
