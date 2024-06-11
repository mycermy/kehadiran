<?php

namespace App\Orchid\Screens\Kehadiran;

use App\Models\Ahli;
use App\Models\Kelas;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class Ahli_ListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'model' => Ahli::filters()
                        ->orderBy('nama')
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
        return 'Senarai Ahli';
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
                TD::make('nama')->sort()->filter(),
                TD::make('nokp', 'No. K/P')->sort()->filter(),
                TD::make('tahap')->sort()->filter(),
                TD::make('kelas_id', 'Kelas')->sort()
                    ->filter(Relation::make()->fromModel(Kelas::class, 'nama_kelas')->searchColumns('ting', 'nama_kelas')->displayAppend('full'))
                    ->render(fn($target) => $target->kelas->ting . ' ' . $target->kelas->nama_kelas ?? null),
            ]),
        ];
    }
}
