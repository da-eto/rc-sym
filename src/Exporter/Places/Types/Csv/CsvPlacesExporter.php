<?php

namespace App\Exporter\Places\Types\Csv;

use App\Exporter\Places\ConcretePlacesExporterInterface;
use App\Exporter\Places\Exception\PlacesExporterException;
use App\Exporter\Places\Stream\TextFileStream;

/**
 * Экспорт в CSV
 *
 * @package App\Exporter\Places\Types\Csv
 */
class CsvPlacesExporter implements ConcretePlacesExporterInterface
{
    private const TYPE = 'csv';

    /**
     * @var CsvPlacesWriter
     */
    private $writer;

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }

    public function __construct(CsvPlacesWriter $writer)
    {
        $this->writer = $writer;
    }

    /**
     * {@inheritDoc}
     */
    public function export(iterable $places, string $type, string $filename): void
    {
        if (!$this->supports($type)) {
            throw new PlacesExporterException(
                "Can't export with unsupported type '{$type}'"
            );
        }

        $stream = new TextFileStream($filename);
        $stream->open();
        $this->writer->writePlaces($places, $stream);
        $stream->close();
    }
}
