<?php

namespace App\Command;

use App\Service\GeoService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'load:geo',
    description: 'Load countries and cities',
)]
class LoadCountriesAndCitiesCommand extends Command
{
    public function __construct(
        private readonly GeoService $geoService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note('start executing...');

        $this->geoService->loadAndSaveGeoData();

        $io->success('Geo data successfully loaded');

        return Command::SUCCESS;
    }
}
