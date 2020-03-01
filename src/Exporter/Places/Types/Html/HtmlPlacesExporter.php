<?php

namespace App\Exporter\Places\Types\Html;

use App\Exporter\Places\ConcretePlacesExporterInterface;
use App\Exporter\Places\PlacesExporterWriterInterface;
use App\Exporter\Places\Writer\TextFileWriter;
use Twig\Environment;

/**
 * Сервис создания экспорта в HTML
 *
 * @package App\Exporter\Places\Types\Html
 */
class HtmlPlacesExporter implements ConcretePlacesExporterInterface
{
    private const TYPE = 'html';

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }

    /**
     * {@inheritDoc}
     */
    public function export(iterable $places, string $type, string $filename): void
    {
        $writer = new TextFileWriter($filename, new HtmlExporterFormatter($this->twig));
        $writer->startWrite();

        foreach ($places as $place) {
            $writer->appendPlace($place);
        }

        $writer->endWrite();
    }
}
