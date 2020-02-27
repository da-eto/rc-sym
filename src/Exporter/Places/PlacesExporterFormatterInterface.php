<?php

namespace App\Exporter\Places;

use App\Entity\Place;

/**
 * Интерфейс форматера для потоковых файлов с независимой генерацией шапки, строк заведений и футера файла.
 *
 * @package App\Exporter\Places
 */
interface PlacesExporterFormatterInterface
{
    /**
     * Возвращает форматированную шапку файла.
     *
     * @return string
     */
    public function formatHeader(): string;

    /**
     * Возвращает форматированную строку для данного заведения.
     *
     * @param Place $place заведение
     *
     * @return string
     */
    public function formatPlace(Place $place): string;

    /**
     * Возвращает форматированный футер файла.
     *
     * @return string
     */
    public function formatFooter(): string;
}
