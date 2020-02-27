<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Place;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Класс фикстур для приложения.
 *
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * Загрузка фикстур.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $cities = [
            'msk' => 'Москва',
            'spb' => 'Санкт-Петербург',
            'ekb' => 'Екатеринбург',
            'nn' => 'Нижний Новгород',
            'sam' => 'Самара',
            'vld' => 'Владивосток',
        ];
        $typeParts = [
            ['Большой', 'Маленький', 'Первый', 'Последний', 'Далёкий', 'Удалённый', 'Близкий', 'Отмороженный', 'Синий'],
            ['красивый', 'маленький', 'уютный', 'замшелый', 'новый', 'старый', 'лаунж', 'хипстерский', 'кибер', 'дешёвый'],
            ['бар', 'паб', 'зал', 'ресторан', 'банкетный зал', 'двор', 'кабак', 'гастробар', 'домик', 'шаурмяк', 'кебаб'],
        ];
        $titleParts = [
            ['Старая', 'Молодая', 'Уверенная', 'Зелёная', 'Синяя', 'Красная', 'Дворовая', 'Дикая', 'Домашняя', 'Добрая'],
            ['собака', 'лошадь', 'кобыла', 'кошка', 'лисица', 'сова', 'партизанка', 'шпионка', 'мышка', 'лавка', 'белочка'],
            ['и Атос', 'Динго', 'Мальвина', 'с миелофоном', 'и Аристотель', 'и Платон', 'хочет домой', 'с саквояжем'],
        ];

        foreach ($cities as $citySlug => $cityName) {
            $city = new City();
            $city->setSlug($citySlug);
            $city->setName($cityName);

            $manager->persist($city);
            $manager->flush();

            $cityId = $city->getId();

            for ($i = 0; $i < 10; $i++) {
                $city = $manager->find(City::class, $cityId);

                for ($j = 0; $j < 1000; $j++) {
                    $name = $this->joinRandomParts($typeParts) . ' "' . $this->joinRandomParts($titleParts) . '"';
                    $slug = 'place-' . $citySlug . '-' . $i  . '-' . $j;
                    $closed = (rand(0, 99) < 20);
                    $active = (!$closed) && (rand(0, 99) < 80);

                    $place = new Place();
                    $place->setName($name);
                    $place->setSlug($slug);
                    $place->setCity($city);
                    $place->setClosed($closed);
                    $place->setActive($active);
                    $place->setCreatedAt(new \DateTimeImmutable('now'));

                    $manager->persist($place);
                }

                $manager->flush();
                $manager->clear();
            }
        }
    }

    /**
     * Возвращает строку из случайного набора частей имени.
     *
     * @param array $nameParts список списков частей имени, например: [['первый', 'второй'], ['дом', 'подъезд']]
     *
     * @return string
     */
    private function joinRandomParts(array $nameParts): string
    {
        return implode(
            ' ',
            array_map(function ($parts) {
                return $parts[array_rand($parts)];
            }, $nameParts)
        );
    }
}
