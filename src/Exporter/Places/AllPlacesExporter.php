<?php

namespace App\Exporter\Places;

use App\Exporter\Places\Exception\PlacesExporterException;
use App\Repository\PlaceRepository;

/**
 * Сервис экспорта заведений в файлы различных форматов
 *
 * @package App\Exporter\Places
 */
class AllPlacesExporter implements PlacesExporterInterface
{
    /**
     * @var PlacesExporterFactoryInterface[]|iterable
     */
    private $exporters;
    /**
     * @var PlaceRepository
     */
    private $placeRepository;

    /**
     * Конструктор PlacesExporter.
     *
     * @param iterable|PlacesExporterFactoryInterface[] $exporters
     * @param PlaceRepository $placeRepository
     */
    public function __construct(iterable $exporters, PlaceRepository $placeRepository)
    {
        $this->exporters = $exporters;
        $this->placeRepository = $placeRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return null !== $this->getExporterForType($type);
    }

    /**
     * Экспортирует заведения в указанный файл.
     *
     * @param string $type тип экспорта
     * @param string $filename имя файла
     *
     * @throws PlacesExporterException
     */
    public function export(string $type, string $filename): void
    {
        if (!$this->supports($type)) {
            throw new PlacesExporterException(
                "Can't export with unsupported type '{$type}'"
            );
        }

        $exporter = $this->getExporterForType($type);

        if (!$exporter instanceof PlacesExporterFactoryInterface) {
            $className = get_class($exporter);
            $interfaceName = PlacesExporterFactoryInterface::class;

            throw new PlacesExporterException(
                "Exporter class {$className} for type '{$type}' must implement {$interfaceName}"
            );
        }

        $exporter->export($this->placeRepository->iterateAll(), $type, $filename);
    }

    /**
     * Получить конкретный экспортер для типа.
     *
     * @param string $type
     *
     * @return PlacesExporterFactoryInterface|null
     */
    private function getExporterForType(string $type): ?PlacesExporterFactoryInterface
    {
        foreach ($this->exporters as $exporter) {
            if ($exporter->supports($type)) {
                return $exporter;
            }
        }

        return null;
    }
}
