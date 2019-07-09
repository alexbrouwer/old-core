<?php declare(strict_types=1);

namespace PAR\Core;

use PAR\Core\Exception\ClassMismatchException;

final class Comparator
{
    /**
     * @return Comparator
     */
    public static function callback(): self
    {
        return new self();
    }

    /**
     * Sort array by ComparableInterface::compareTo
     *
     * @param array<ComparableInterface> $array The array to sort
     *
     * @return array
     */
    public static function sortArray(array $array): array
    {
        $sorted = array_map(
            static function ($item, $key) {
                if (!$item instanceof ComparableInterface) {
                    throw ClassMismatchException::expectedTypeInArray(ComparableInterface::class, (string)$key, $item);
                }

                return $item;
            },
            $array,
            array_keys($array)
        );
        uasort($sorted, static::callback());

        return $sorted;
    }

    private function __construct()
    {
        // Make sure it cannot be instantiated
    }

    /**
     * @param ComparableInterface $a
     * @param ComparableInterface $b
     *
     * @return int
     */
    public function __invoke(ComparableInterface $a, ComparableInterface $b): int
    {
        return $a->compareTo($b);
    }
}
