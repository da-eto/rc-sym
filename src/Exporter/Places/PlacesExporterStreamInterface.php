<?php

namespace App\Exporter\Places;

/**
 * Интерфейс писателя для потокового сохранения экспортируемых заведений в файл.
 *
 * @package App\Exporter\Places
 */
interface PlacesExporterStreamInterface
{
    /**
     * Добавить данные в поток.
     *
     * @param string $text
     */
    public function append(string $text): void;

    /**
     * Возвращает рерурс (хэндл) записываемого потока.
     *
     * @return mixed
     */
    public function getHandle();
}
