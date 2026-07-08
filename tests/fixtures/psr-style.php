<?php

declare(strict_types=1);

namespace WPTechnix\Fixtures;

/**
 * PSR-style fixture for the formatting-deadlock check.
 *
 * Four-space indentation. Kept clean under WPTechnix-PSR for the indent sniff.
 */
final class PsrStyleFixture
{
    /**
     * Merge caller values over the defaults.
     *
     * @param array<string, int> $input Caller values.
     *
     * @return array<string, int>
     */
    public function merge(array $input): array
    {
        $defaults = [
            'alpha' => 1,
            'beta'  => 2,
        ];

        if ($input === []) {
            return $defaults;
        }

        return $input;
    }
}
