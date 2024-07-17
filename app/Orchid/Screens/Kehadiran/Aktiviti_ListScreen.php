<?php

namespace App\Orchid\Screens\Kehadiran;

use App\Models\Aktiviti;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

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
        return 'Senarai Aktiviti';
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
            ModalToggle::make('New Aktiviti')
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
                TD::make('tarikh')->sort()->filter(TD::FILTER_DATE_RANGE),
                // TD::make('tarikh')->sort()->filter(TD::FILTER_DATE),
                TD::make('masa_mula', 'Masa Mula')->sort()->filter(),
                TD::make('nama_aktiviti','Nama Aktiviti')->sort()->filter(),

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
                DateTimer::make('aktiviti.tarikh')
                    ->title('Tarikh')
                    ->required()
                    ->allowInput()
                    ->horizontal(),

                DateTimer::make('aktiviti.masa_mula')
                    ->title('Masa Mula')
                    ->noCalendar()
                    ->format('h:i K') // Specify time format
                    // ->allowInput()
                    ->required()
                    ->horizontal(),

                Input::make('aktiviti.nama_aktiviti')
                    ->title('Nama Aktiviti')
                    ->required()
                    ->horizontal(),
                
                TextArea::make('aktiviti.keterangan')
                    ->title('Keterangan Aktiviti')
                    ->rows(5)
                    ->horizontal(),
            ]))->title('Create New Aktiviti'),

            // Edit Modal
            Layout::modal('asyncEditModal', Layout::rows([
                DateTimer::make('aktiviti.tarikh')
                    ->title('Tarikh')
                    ->required()
                    ->allowInput()
                    ->horizontal(),

                DateTimer::make('aktiviti.masa_mula')
                    ->title('Masa Mula')
                    ->noCalendar()
                    ->format('h:i K') // Specify time format
                    // ->allowInput()
                    ->required()
                    ->horizontal(),

                Input::make('aktiviti.nama_aktiviti')
                    ->title('Nama Aktiviti')
                    ->required()
                    ->horizontal(),
                
                TextArea::make('aktiviti.keterangan')
                    ->title('Keterangan Aktiviti')
                    ->rows(5)
                    ->horizontal(),
            ]))->async('asyncGetAktiviti'),
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
                        ->modalTitle('Edit Aktiviti: ' . $target->nama_aktiviti)
                        ->method('update')
                        ->asyncParameters([
                            'aktiviti' => $target->id,
                        ]),

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the aktiviti is deleted, all of its resources and data will be permanently deleted. Before deleting your contact, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'id' => $target->id,
                        ]),
                ]),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Aktiviti $aktiviti)
    {
        $aktiviti->fill($request->get('aktiviti'));

        $aktiviti->save();


        Toast::info(__('Aktiviti was saved.'));

        return redirect()->route('kehadiran.aktiviti');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Aktiviti $aktiviti)
    {
        $aktiviti->fill($request->input('aktiviti'));

        $aktiviti->save();

        Toast::info(__('Aktiviti was updated.'));

        return redirect()->route('kehadiran.aktiviti');
    }

    public function remove(Request $request): void
    {
        $itemToRemove = Aktiviti::findOrFail($request->get('id'));

        $itemToRemove->delete();

        Toast::info(__('Aktiviti was removed'));
    }

    /**
     * @return array
     */
    public function asyncGetAktiviti(Aktiviti $aktiviti): iterable
    {
        return [
            'aktiviti' => $aktiviti,
        ];
    }
}
