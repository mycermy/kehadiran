<?php

namespace App\Orchid\Screens\Kehadiran;

use App\Models\Aktiviti;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class Aktiviti_ListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'model' => Aktiviti::filters()
                        ->orderBy('tarikh', 'desc')
                        ->orderBy('nama_aktiviti')
                        ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Aktiviti_ListScreen';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all roles, including their permissions and associated users.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('model', [
                TD::make('id', '#')->render(fn ($target, object $loop) => $loop->iteration + (request('page') > 0 ? (request('page') - 1) * $target->getPerPage() : 0)),
                TD::make('tarikh')->sort()->filter(TD::FILTER_DATE_RANGE),
                // TD::make('tarikh')->sort()->filter(TD::FILTER_DATE),
                TD::make('masa_mula')->sort()->filter(),
                TD::make('nama_aktiviti')->sort()->filter(),
            ]),
        ];
    }
}
