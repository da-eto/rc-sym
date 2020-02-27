<?php

namespace App\Exporter\Places;

use App\Exporter\Places\Exception\PlacesExporterException;
use App\Exporter\Places\Types\Csv\CsvExporterFactory;
use App\Exporter\Places\Types\Html\HtmlExporterFactory;
use App\Exporter\Places\Types\Xml\XmlExporterFactory;
use App\Repository\PlaceRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

/**
 * Сервис экспорта заведений в файлы различных форматов
 *
 * @package App\Exporter\Places
 */
class PlacesExporter implements PlacesExporterInterface, ServiceSubscriberInterface
{
    /**
     * Фабрики экспорта в формате ['тип' => 'имя класса']
     */
    private const EXPORTER_FACTORIES = [
        'csv' => CsvExporterFactory::class,
        'xml' => XmlExporterFactory::class,
        'html' => HtmlExporterFactory::class,
    ];
    /**
     * Размер выборки для пакетной загрузки заведений.
     */
    private const BATCH_SIZE = 1000;

    /**
     * @var ContainerInterface
     */
    private $factoriesLocator;
    /**
     * @var PlaceRepository
     */
    private $placeRepository;

    /**
     * Конструктор PlacesExporter.
     *
     * @param ContainerInterface $factoriesLocator контейнер внутреннего сервис-локатора
     * @param PlaceRepository $placeRepository
     */
    public function __construct(ContainerInterface $factoriesLocator, PlaceRepository $placeRepository)
    {
        $this->factoriesLocator = $factoriesLocator;
        $this->placeRepository = $placeRepository;
    }

    public static function getSubscribedServices()
    {
        return self::EXPORTER_FACTORIES;
    }

    public function supports(string $type): bool
    {
        return array_key_exists($type, self::EXPORTER_FACTORIES);
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
        if (!$this->factoriesLocator->has($type)) {
            throw new PlacesExporterException(
                "Can't export with unsupported type '{$type}'"
            );
        }

        $factory = $this->factoriesLocator->get($type);

        if (!$factory instanceof PlacesExporterFactoryInterface) {
            $className = get_class();
            $interfaceName = PlacesExporterFactoryInterface::class;

            throw new PlacesExporterException(
                "Exporter class {$className} for type '{$type}' must implement {$interfaceName}"
            );
        }

        $writer = $factory->createWriter($filename);
        $writer->startWrite();
        $latestId = 0;
        $places = $this->placeRepository->findWithGreaterIdOrderedById($latestId, self::BATCH_SIZE);

        while (count($places) > 0) {
            foreach ($places as $place) {
                $writer->appendPlace($place);
                $latestId = $place->getId();
            }

            $this->placeRepository->clear();
            $places = $this->placeRepository->findWithGreaterIdOrderedById($latestId, self::BATCH_SIZE);
        }

        $writer->endWrite();
    }
}
