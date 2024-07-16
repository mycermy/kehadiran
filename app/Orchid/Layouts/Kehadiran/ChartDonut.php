<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Kehadiran;

use Orchid\Screen\Layouts\Chart;

class ChartDonut extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage','donut'.
     *
     * @var string
     */
    protected $type = 'donut';

    /**
     * @var int
     */
    protected $height = 330;

    /**
     * Limiting the slices.
     *
     * When there are too many data values to show visually,
     * it makes sense to bundle up the least of the values as a cumulated data point,
     * rather than showing tiny slices.
     *
     * @var int
     */
    protected $maxSlices = 6;

}
