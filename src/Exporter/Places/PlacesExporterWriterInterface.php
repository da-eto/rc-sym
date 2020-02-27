<?php

namespace App\Exporter\Places;

use App\Entity\Place;

/**
 * Интерфейс писателя для потокового сохранения экспортируемых заведений в файл.
 *
 * @package App\Exporter\Places
 */
interface PlacesExporterWriterInterface
{
    /**
     * Начать запись.
     */
    public function startWrite(): void;

    /**
     * Добавить информацию о заведении в файл.
     *
     * @param Place $place
     */
    public function appendPlace(Place $place): void;

    /**
     * Закончить запись.
     */
    public function endWrite(): void;
}
