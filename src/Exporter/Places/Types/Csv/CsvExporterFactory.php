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
    public function createWriter(string $filename): PlacesExporterWriterInterface
    {
        return new TextFileWriter($filename, new CsvExporterFormatter());
    }
}
