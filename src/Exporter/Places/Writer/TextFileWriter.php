<?php

namespace App\Exporter\Places\Writer;

use App\Entity\Place;
use App\Exporter\Places\Exception\PlacesExporterWriterException;
use App\Exporter\Places\PlacesExporterFormatterInterface;
use App\Exporter\Places\PlacesExporterWriterInterface;

/**
 * Класс записи экспорта в текстовые файлы при помощи форматера
 *
 * @package App\Exporter\Places\Writer
 */
class TextFileWriter implements PlacesExporterWriterInterface
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
     * @var PlacesExporterFormatterInterface
     */
    private $formatter;

    /**
     * Конструктор TextFileWriter.
     *
     * @param string $filename имя выходного файла
     * @param PlacesExporterFormatterInterface $formatter используемый форматер
     */
    public function __construct(string $filename, PlacesExporterFormatterInterface $formatter)
    {
        $this->filename = $filename;
        $this->formatter = $formatter;
    }

    /**
     * @throws PlacesExporterWriterException
     */
    public function startWrite(): void
    {
        if ($this->handle !== null) {
            throw new PlacesExporterWriterException(
                "File '{$this->filename}' already opened"
            );
        }

        $this->handle = fopen($this->filename, 'w');

        if ($this->handle === false) {
            throw new PlacesExporterWriterException(
                "Can't open file '{$this->filename}'"
            );
        }

        $this->append($this->formatter->formatHeader());
    }

    /**
     * @param Place $place заведение
     * @throws PlacesExporterWriterException
     */
    public function appendPlace(Place $place): void
    {
        $this->append($this->formatter->formatPlace($place));
    }

    /**
     * @throws PlacesExporterWriterException
     */
    public function endWrite(): void
    {
        if ($this->handle === null || $this->handle === false) {
            throw new PlacesExporterWriterException(
                "Can't close not opened file '{$this->filename}'"
            );
        }

        $this->append($this->formatter->formatFooter());

        $success = fclose($this->handle);

        if ($success === false) {
            throw new PlacesExporterWriterException(
                "Can't close file '{$this->filename}'"
            );
        }
    }

    /**
     * Добавление текста в файл.
     *
     * @param string $text
     *
     * @throws PlacesExporterWriterException
     */
    private function append(string $text)
    {
        $success = fputs($this->handle, $text);

        if ($success === false) {
            throw new PlacesExporterWriterException(
                "Can't write to '{$this->filename}' text '{$text}'"
            );
        }
    }
}
