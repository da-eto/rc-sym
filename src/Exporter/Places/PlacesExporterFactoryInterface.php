<?php

namespace App\Exporter\Places;

use App\Entity\Place;

/**
 * Интерфейс конкретной реализации экспорта.
 *
 * @package App\Exporter\Places
 */
interface PlacesExporterFactoryInterface
{
    /**
     * Поддерживает ли экспортер переданный тип?
     *
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;

    /**
     * Экспорт заведений в файл.
     *
     * @param iterable|Place[] $places заведения
     * @param string $type тип экспорта
     * @param string $filename имя файла
     */
    public function export(iterable $places, string $type, string $filename): void;
}
