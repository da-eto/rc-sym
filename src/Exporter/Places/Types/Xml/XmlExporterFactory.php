<?php

namespace App\Exporter\Places\Types\Xml;

use App\Exporter\Places\PlacesExporterFactoryInterface;
use App\Exporter\Places\PlacesExporterWriterInterface;

/**
 * Сервис создания экспорта в XML
 *
 * @package App\Exporter\Places\Types\Xml
 */
class XmlExporterFactory implements PlacesExporterFactoryInterface
{
    public function createWriter(string $filename): PlacesExporterWriterInterface
    {
        return new XmlExporterWriter($filename);
    }
}
