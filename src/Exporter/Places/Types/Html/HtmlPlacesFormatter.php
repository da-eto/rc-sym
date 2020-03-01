<?php

namespace App\Exporter\Places\Types\Html;

use App\Entity\Place;
use Twig\Environment;

/**
 * Форматер экспорта в HTML
 *
 * @package App\Exporter\Places\Types\Html
 */
class HtmlPlacesFormatter
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param iterable|Place[] $places
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function format(iterable $places): string {
        return $this->twig->render('exporter/places.html.twig', ['places' => $places]);
    }
}
