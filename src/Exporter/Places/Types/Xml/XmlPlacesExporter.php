<?php

namespace App\Exporter\Places\Types\Xml;

use App\Exporter\Places\ConcretePlacesExporterInterface;
use App\Exporter\Places\PlacesExporterWriterInterface;

/**
 * Сервис создания экспорта в XML
 *
 * @package App\Exporter\Places\Types\Xml
 */
class XmlPlacesExporter implements ConcretePlacesExporterInterface
{
    private const TYPE = 'xml';

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
        $writer = new XmlExporterWriter($filename);
        $writer->startWrite();

        foreach ($places as $place) {
            $writer->appendPlace($place);
        }

        $writer->endWrite();
    }
}