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
     * Создаёт объект для записи экспорта в файл.
     *
     * @param string $filename
     *
     * @return PlacesExporterWriterInterface
     */
    public function createWriter(string $filename): PlacesExporterWriterInterface;
}
