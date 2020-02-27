<?php

namespace App\Exporter\Places\Types\Html;

use App\Exporter\Places\PlacesExporterFactoryInterface;
use App\Exporter\Places\PlacesExporterWriterInterface;
use App\Exporter\Places\Writer\TextFileWriter;
use Twig\Environment;

/**
 * Сервис создания экспорта в HTML
 *
 * @package App\Exporter\Places\Types\Html
 */
class HtmlExporterFactory implements PlacesExporterFactoryInterface
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function createWriter(string $filename): PlacesExporterWriterInterface
    {
        return new TextFileWriter($filename, new HtmlExporterFormatter($this->twig));
    }
}
