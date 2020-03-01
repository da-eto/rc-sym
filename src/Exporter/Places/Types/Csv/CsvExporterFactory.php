<?php

namespace App\Exporter\Places\Types\Csv;

use App\Exporter\Places\PlacesExporterFactoryInterface;
use App\Exporter\Places\PlacesExporterWriterInterface;
use App\Exporter\Places\Writer\TextFileWriter;

/**
 * Сервис создания экспорта в CSV
 *
 * @package App\Exporter\Places\Types\Csv
 */
class CsvExporterFactory implements PlacesExporterFactoryInterface
{
    private const TYPE = 'csv';

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
        $writer = new TextFileWriter($filename, new CsvExporterFormatter());
        $writer->startWrite();

        foreach ($places as $place) {
            $writer->appendPlace($place);
        }

        $writer->endWrite();
    }}
