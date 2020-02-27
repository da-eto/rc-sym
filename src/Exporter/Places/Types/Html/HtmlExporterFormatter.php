<?php

namespace App\Exporter\Places\Types\Html;

use App\Entity\Place;
use App\Exporter\Places\PlacesExporterFormatterInterface;
use Twig\Environment;

/**
 * Форматер экспорта в HTML
 *
 * @package App\Exporter\Places\Types\Html
 */
class HtmlExporterFormatter implements PlacesExporterFormatterInterface
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function formatHeader(): string
    {
        return $this->twig->render('exporter/header.html.twig');
    }

    public function formatPlace(Place $place): string
    {
        return $this->twig->render('exporter/place.html.twig', ['place' => $place]);
    }

    public function formatFooter(): string
    {
        return $this->twig->render('exporter/footer.html.twig');
    }
}