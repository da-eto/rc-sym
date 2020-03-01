<?php

namespace App\Exporter\Places\Stream;

use App\Exporter\Places\Exception\PlacesExporterStreamException;
use App\Exporter\Places\PlacesExporterStreamInterface;

/**
 * Класс записи экспорта в текстовые файлы
 *
 * @package App\Exporter\Places\Writer
 */
class TextFileStream implements PlacesExporterStreamInterface
{
    /**
     * @var string
     */
    private $filename;
    /**
     * @var resource|null|false
     */
    private $handle;

    /**
     * Конструктор TextFileWriter.
     *
     * @param string $filename имя выходного файла
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandle()
    {
        return $this->handle;
    }


    /**
     * Добавление текста в файл.
     *
     * @param string $text
     *
     * @throws PlacesExporterStreamException
     */
    public function append(string $text): void
    {
        $success = fputs($this->handle, $text);

        if ($success === false) {
            throw new PlacesExporterStreamException(
                "Can't write to '{$this->filename}' text '{$text}'"
            );
        }
    }

    /**
     * @throws PlacesExporterStreamException
     */
    public function open(): void
    {
        if ($this->handle !== null) {
            throw new PlacesExporterStreamException(
                "File '{$this->filename}' already opened"
            );
        }

        $this->handle = fopen($this->filename, 'w');

        if ($this->handle === false) {
            throw new PlacesExporterStreamException(
                "Can't open file '{$this->filename}'"
            );
        }
    }

    /**
     * @throws PlacesExporterStreamException
     */
    public function close(): void
    {
        if ($this->handle === null || $this->handle === false) {
            throw new PlacesExporterStreamException(
                "Can't close not opened file '{$this->filename}'"
            );
        }

        $success = fclose($this->handle);

        if ($success === false) {
            throw new PlacesExporterStreamException(
                "Can't close file '{$this->filename}'"
            );
        }
    }
}
