<?php

namespace App\Exporter\Places\Types\Csv;

use App\Entity\Place;
use App\Exporter\Places\PlacesExporterFormatterInterface;

/**
 * Форматер экспорта заведений в CSV
 *
 * @package App\Exporter\Places\Types\Csv
 */
class CsvExporterFormatter implements PlacesExporterFormatterInterface
{
    public function formatHeader(): string
    {
        return '';
    }

    public function formatPlace(Place $place): string
    {
        $fields = [
            $place->getId(),
            $place->getName(),
            $place->getSlug(),
            ($place->getActive() ? 1 : 0),
            ($place->getClosed() ? 1 : 0),
            $place->getCity()->getName(),
            $place->getCity()->getSlug(),
            $place->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        $buffer = fopen('php://memory', 'r+');
        $success = fputcsv($buffer, $fields);
        rewind($buffer);

        return stream_get_contents($buffer);
    }

    public function formatFooter(): string
    {
        return '';
    }
}