<?php

namespace App\Exporter\Places\Types\Html;

use App\Exporter\Places\ConcretePlacesExporterInterface;
use App\Exporter\Places\Stream\TextFileStream;

/**
 * Экспорт в HTML
 *
 * @package App\Exporter\Places\Types\Html
 */
class HtmlPlacesExporter implements ConcretePlacesExporterInterface
{
    private const TYPE = 'html';

    /**
     * @var HtmlPlacesFormatter
     */
    private $formatter;

    public function __construct(HtmlPlacesFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }

    /**
     * {@inheritDoc}
     */
    public function export(iterable $places, string $type, string $filename): void
    {
        $stream = new TextFileStream($filename);
        $stream->open();
        $stream->append($this->formatter->format($places));
        $stream->close();
    }
}
