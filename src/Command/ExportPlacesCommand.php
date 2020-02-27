<?php

namespace App\Command;

use App\Exporter\Places\PlacesExporterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Команда экспорта заведений в файл.
 *
 * @package App\Command
 */
class ExportPlacesCommand extends Command
{
    /**
     * @var PlacesExporterInterface
     */
    private $placeExporter;

    protected static $defaultName = 'app:export-places';

    public function __construct(PlacesExporterInterface $placeExporter)
    {
        $this->placeExporter = $placeExporter;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Экспорт заведений в файл')
            ->addArgument('type', InputArgument::REQUIRED, 'Тип экспорта (формат выходного файла).')
            ->addArgument('filename', InputArgument::REQUIRED, 'Имя выходного файла');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $type = $input->getArgument('type');
        $filename = $input->getArgument('filename');

        if (!$this->placeExporter->supports($type)) {
            $io->error("Тип экспорта '{$type}' не поддерживается");

            return -1;
        }

        $this->placeExporter->export($type, $filename);
        $io->success("Экспорт успешно завершён, результат в файле: '{$filename}'");

        return 0;
    }
}
