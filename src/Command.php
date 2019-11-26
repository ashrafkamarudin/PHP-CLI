<?php namespace Osky;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * Author: Ashraf Kamarudin <ashrafkamarudin@gmail.com>
 */
class Command extends SymfonyCommand
{
    
    public function __construct()
    {
        parent::__construct();
    }

    protected function searchPost(InputInterface $input, OutputInterface $output, $data)
    {

        $jsonResult = @file_get_contents('https://www.reddit.com/r/' . $data['subreddit'] .  '/search.json?q=title:' . $data['search_term'] . '&restrict_sr=on');

        if (!$jsonResult) {
            $error = error_get_last();
            $output -> writeln( "HTTP request failed. Error was: " . $error['message']);
        } else {
            // outputs multiple lines to the console (adding "\n" at the end of each line)
            $output -> writeln([
                '',
                '====**** Search Reddit Console App ****====',
                '==========================================',
                '',
            ]);

            $result = json_decode($jsonResult, true);

            $tableRow = [];
    
            foreach ($result['data']['children'] as $post) {
                $tableRow[] = [
                    date("Y-m-d H:i:s ",$post['data']['created']),
                    substr($post['data']['title'], 0, 30),
                    $post['data']['url']
                ];
            }
    
            $table = new Table($output);
            $table
                ->setHeaders(['Date', 'Title', 'URL'])
                ->setRows($tableRow)
            ;
            $table->setColumnMaxWidth(0, 20);
            $table->setColumnMaxWidth(1, 30);
            $table->render();
        }
    }
}
