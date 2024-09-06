<?php
namespace App\Command;

use App\Service\StatisticService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Scheduler\Attribute\AsPeriodicTask;

// This command process end send the weekly top 10
#[AsCommand(name: 'app:weekly-stats')]
#[AsPeriodicTask('7 days', from: '2024-09-01', schedule: 'default')]
class StatisticCommand extends Command
{
    private StatisticService $statisticService;
    public function __construct(StatisticService $statisticService) {
        parent::__construct();
        $this->statisticService = $statisticService;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $this->statisticService->run();

        $output->writeln(' Top 10 stats computed');
        return Command::SUCCESS;
    }
}