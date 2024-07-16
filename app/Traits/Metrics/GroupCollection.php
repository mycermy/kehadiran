<?php

namespace App\Traits\Metrics;

use Illuminate\Support\Collection;

class GroupCollection extends Collection
{
    /**
     * @param \Closure|null $closure
     *
     * @return array
     */
    public function toChart(\Closure $closure = null): array
    {
        $closure = $closure ?? static fn ($label) => $label;

        // dd($this->items);
        // dd($this->pluck('value'));

        return $this
            ->sortByDesc('value')
            ->pluck('label')
            ->map(fn (string $name) => [
                'labels' => $this->pluck('label')->map($closure)->toArray(),
                'values' => $this->getChartsValues($name),
            ])
            ->toArray();
    }
    public function toChart_mod(/*string $name,*/ \Closure $closure = null): array
    {
        $closure = $closure ?? static fn ($label) => $label;

        return [
            //'name'   => $name,
            'labels' => $this->pluck('label')->map($closure)->toArray(),
            'values' => $this->pluck('value')->toArray(),
        ];
    }
    public function toChart_mod2(string $name, string $chartType = 'bar', string $axisID = 'left-axis', \Closure $closure = null): array
    {
        $closure = $closure ?? static fn ($label) => $label;

        return [
            'name'   => $name,
            'chartType' => $chartType,
            'axisID' => $axisID,
            'labels' => $this->pluck('label')->map($closure)->toArray(),
            'values' => $this->pluck('value')->toArray(),
        ];
    }

    /**
     * @param string $name
     *
     * @return array
     */
    private function getChartsValues(string $name): array
    {
        return $this
            ->map(static fn ($item) => $item->label === $name ? (int) $item->value : 0)
            ->toArray();
    }
}
