<?php

namespace App\Exporter\Places\Types\Xml;

use App\Entity\Place;
use App\Exporter\Places\Exception\PlacesExporterStreamException;

/**
 * Класс записи экспорта в XML
 *
 * @package App\Exporter\Places\Types\Xml
 */
class XmlPlacesWriter
{
    /**
     * @var string
     */
    private $filename;
    /**
     * @var \XMLWriter
     */
    private $xmlWriter;

    /**
     * CsvPlacesExporterWriter constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function startWrite(): void
    {
        $this->xmlWriter = new \XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
        $this->xmlWriter->startElement('places');
    }

    public function appendPlace(Place $place): void
    {
        $this->xmlWriter->startElement('place');

        $this->xmlWriter->startAttribute('id');
        $this->xmlWriter->text($place->getId());
        $this->xmlWriter->endAttribute();

        $this->xmlWriter->startAttribute('active');
        $this->xmlWriter->text($place->getActive() ? 1 : 0);
        $this->xmlWriter->endAttribute();

        $this->xmlWriter->startAttribute('closed');
        $this->xmlWriter->text($place->getClosed() ? 1 : 0);
        $this->xmlWriter->endAttribute();

        $this->xmlWriter->startAttribute('cityId');
        $this->xmlWriter->text($place->getCity()->getId());
        $this->xmlWriter->endAttribute();

        $this->xmlWriter->startAttribute('slug');
        $this->xmlWriter->text($place->getSlug());
        $this->xmlWriter->endAttribute();

        $this->xmlWriter->text($place->getName());

        $this->xmlWriter->endElement();
    }

    public function endWrite(): void
    {
        $this->xmlWriter->endDocument();
        $success = file_put_contents($this->filename, $this->xmlWriter->outputMemory());

        if ($success === false) {
            throw new PlacesExporterStreamException(
                "Can't write to '{$this->filename}'"
            );
        }
    }
}
