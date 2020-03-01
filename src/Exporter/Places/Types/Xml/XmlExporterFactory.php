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
    private const TYPE = 'xml';

    public function createWriter(string $filename): PlacesExporterWriterInterface
    {
        return new XmlExporterWriter($filename);
    }

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }
}
