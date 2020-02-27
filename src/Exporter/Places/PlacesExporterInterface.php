<?php

namespace App\Exporter\Places;

/**
 * Интерфейс экспортера заведений.
 *
 * @package App\Exporter\Places
 */
interface PlacesExporterInterface
{
    /**
     * Поддерживает ли экспортер переданный тип экспорта?
     *
     * @param string $type тип экспорта
     *
     * @return bool
     */
    public function supports(string $type): bool;

    /**
     * Экспортирует заведения в указанный файл.
     *
     * @param string $type тип экспорта
     * @param string $filename имя файла
     */
    public function export(string $type, string $filename): void;
}
