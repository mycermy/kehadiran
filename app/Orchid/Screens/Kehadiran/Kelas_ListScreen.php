<?php

namespace App\Orchid\Screens\Kehadiran;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class Kelas_ListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'model' => Kelas::withCount('ahlis')->filters()
                        ->orderBy('ting')
                        ->orderBy('nama_kelas')
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
        return 'Senarai Kelas';
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
        return [
            ModalToggle::make('New Kelas')
                ->modal('xpressAddModal')
                ->method('store')
                // ->parameters([
                //     'contactType' => Contact::TYPE_CUSTOMER
                // ])
                ->icon('bs.plus-circle'),
        ];
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
                TD::make('full', 'Kelas'),
                TD::make('ting', 'Tingkatan')->sort()->filter()->alignCenter(),
                TD::make('nama_kelas', 'Nama Kelas')->sort()->filter(),
                TD::make('ahlis_count', 'Jumlah Ahli')->alignCenter(),

                TD::make('Actions')
                // ->canSee(Auth::user()->hasAnyAccess(['platform.contacts.editor']))
                ->width('10px')
                ->render(
                    fn ($target) =>
                    $this->getTableActions($target)
                        ->alignCenter()
                        ->autoWidth()
                        ->render()
                ),
            ]),

            //Add Modal
            Layout::modal('xpressAddModal', Layout::rows([
                Input::make('kelas.ting')
                    ->title('Tingkatan')
                    ->required()
                    ->horizontal(),

                Input::make('kelas.nama_kelas')
                    ->title('Nama Aktiviti')
                    ->required()
                    ->horizontal(),
            ]))->title('Create New Kelas'),

            // Edit Modal
            Layout::modal('asyncEditModal', Layout::rows([
                Input::make('kelas.ting')
                    ->title('Tingkatan')
                    ->required()
                    ->horizontal(),

                Input::make('kelas.nama_kelas')
                    ->title('Nama Aktiviti')
                    ->required()
                    ->horizontal(),
            ]))->async('asyncGetKelas'),
        ];
    }

    /**
     * @param Model $model
     *
     * @return Group
     */
    private function getTableActions($target): Group
    {
        return Group::make([

            DropDown::make()
                ->icon('three-dots-vertical')
                ->list([
                    ModalToggle::make('Edit')
                        ->icon('pencil')
                        ->modal('asyncEditModal')
                        ->modalTitle('Edit Kelas: ' . $target->full)
                        ->method('update')
                        ->asyncParameters([
                            'kelas' => $target->id,
                        ]),

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the kelas is deleted, all of its resources and data will be permanently deleted. Before deleting your contact, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'id' => $target->id,
                        ]),
                ]),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Kelas $kelas)
    {
        $kelas->fill($request->get('kelas'));

        $kelas->save();


        Toast::info(__('Kelas was saved.'));

        return redirect()->route('kehadiran.kelas');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Kelas $kelas)
    {
        $kelas->fill($request->input('kelas'));

        $kelas->save();

        Toast::info(__('Kelas was updated.'));

        return redirect()->route('kehadiran.kelas');
    }

    public function remove(Request $request): void
    {
        $itemToRemove = Kelas::findOrFail($request->get('id'));

        $itemToRemove->delete();

        Toast::info(__('Kelas was removed'));
    }

    /**
     * @return array
     */
    public function asyncGetKelas(Kelas $kelas): iterable
    {
        return [
            'kelas' => $kelas,
        ];
    }
}
