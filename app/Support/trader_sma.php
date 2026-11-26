<?php

/**
 * Pure-PHP replacement for the PECL trader extension's trader_sma().
 *
 * Kept API-compatible with the extension: returns an array keyed from
 * ($timePeriod - 1) to (count - 1), or false when the period is invalid.
 */
if (! function_exists('trader_sma')) {
    function trader_sma(array $real, int $timePeriod = 30)
    {
        $count = count($real);
        $values = array_values($real);

        if ($timePeriod < 2 || $timePeriod > $count || $count === 0) {
            return false;
        }

        $result = [];
        $sum = 0.0;

        for ($i = 0; $i < $timePeriod; $i++) {
            $sum += (float) $values[$i];
        }

        $result[$timePeriod - 1] = $sum / $timePeriod;

        for ($i = $timePeriod; $i < $count; $i++) {
            $sum += (float) $values[$i] - (float) $values[$i - $timePeriod];
            $result[$i] = $sum / $timePeriod;
        }

        return $result;
    }
}
