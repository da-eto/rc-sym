<?php

namespace App\Exporter\Places;

/**
 * Интерфейс для создания писателя экспорта.
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
     * Создаёт объект для записи экспорта в файл.
     *
     * @param string $filename
     *
     * @return PlacesExporterWriterInterface
     */
    public function createWriter(string $filename): PlacesExporterWriterInterface;
}
