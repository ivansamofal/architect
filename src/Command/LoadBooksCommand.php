<?php

namespace App\Command;

use App\Service\AuthorService;
use App\Service\BookService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'load:books',
    description: 'Load books from existing authors',
)]
class LoadBooksCommand extends Command
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly BookService $bookService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note('start executing...');

        $authors = $this->authorService->getAll();
        $this->bookService->loadBooksFromApi($authors);

        $io->success('Books successfully loaded');

        return Command::SUCCESS;
    }
}
