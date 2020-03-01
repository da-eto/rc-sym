<?php

namespace App\Exporter\Places\Types\Csv;

use App\Entity\Place;
use App\Exporter\Places\PlacesExporterStreamInterface;

/**
 * Пишет форматированные заведения в формате CSV в поток
 *
 * @package App\Exporter\Places\Types\Csv
 */
class CsvPlacesWriter
{
    /**
     * @param iterable|Place[] $places
     * @param PlacesExporterStreamInterface $stream
     */
    public function writePlaces(iterable $places, PlacesExporterStreamInterface $stream)
    {
        foreach ($places as $place) {
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

            fputcsv($stream->getHandle(), $fields);
        }
    }
}
