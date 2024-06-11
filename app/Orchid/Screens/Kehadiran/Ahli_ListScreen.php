<?php

namespace App\Orchid\Screens\Kehadiran;

use App\Models\Ahli;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

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
        return [
            ModalToggle::make('New Ahli')
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
                TD::make('nama')->sort()->filter(),
                TD::make('nokp', 'No. K/P')->sort()->filter(),
                TD::make('tahap')->sort()->filter(),
                TD::make('kelas_id', 'Kelas')->sort()
                    ->filter(Relation::make()->fromModel(Kelas::class, 'nama_kelas')->searchColumns('ting', 'nama_kelas')->displayAppend('full'))
                    ->render(fn($target) => $target->kelas->ting . ' ' . $target->kelas->nama_kelas ?? null),

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
                Input::make('ahli.nama')
                    ->title('Nama')
                    ->required()
                    ->horizontal(),

                Input::make('ahli.nokp')
                    ->title('No. K/P')
                    ->required()
                    ->horizontal(),

                Input::make('ahli.tahap')
                    ->title('Tahap')
                    ->required()
                    ->horizontal(),

                Relation::make('ahli.kelas_id')
                    ->fromModel(Kelas::class, 'nama_kelas')
                    ->searchColumns('ting', 'nama_kelas')
                    ->displayAppend('full')
                    ->title('Kelas')
                    ->required()
                    ->horizontal(),
                // 
                Password::make('ahli.katalaluan')
                    ->placeholder('Enter the password to be set')
                    ->title(__('Katalaluan'))
                    ->required()
                    ->horizontal(),
                //  
            ]))->title('Create New Ahli')->rawClick(),

            // Edit Modal
            Layout::modal('asyncEditModal', Layout::rows([
                Input::make('ahli.nama')
                    ->title('Nama')
                    ->required()
                    ->horizontal(),

                Input::make('ahli.nokp')
                    ->title('No. K/P')
                    ->required()
                    ->horizontal(),

                Input::make('ahli.tahap')
                    ->title('Tahap')
                    ->required()
                    ->horizontal(),

                Relation::make('ahli.kelas_id')
                    ->fromModel(Kelas::class, 'nama_kelas')
                    ->searchColumns('ting', 'nama_kelas')
                    ->displayAppend('full')
                    ->title('Kelas')
                    ->required()
                    ->horizontal(),
                
                Password::make('ahli.katalaluan')
                    ->placeholder('Leave empty to keep current password')
                    ->title(__('Katalaluan'))
                    ->horizontal(),
            ]))->async('asyncGetAhli'),
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
                        ->modalTitle('Edit Ahli: ' . $target->full)
                        ->method('update')
                        ->asyncParameters([
                            'ahli' => $target->id,
                        ]),

                    Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the ahli is deleted, all of its resources and data will be permanently deleted. Before deleting your contact, please download any data or information that you wish to retain.'))
                        ->method('remove', [
                            'id' => $target->id,
                        ]),
                ]),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Ahli $ahli)
    {
        $ahli->when($request->filled('ahli.katalaluan'), function (Builder $builder) use ($request) {
            $builder->getModel()->katalaluan = Hash::make($request->input('ahli.katalaluan'));
        });

        $ahli
            ->fill($request->collect('ahli')->except(['katalaluan'])->toArray())
            ->save();


        Toast::info(__('Ahli was saved.'));

        return redirect()->route('kehadiran.ahli');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Ahli $ahli)
    {
        $ahli->when($request->filled('ahli.katalaluan'), function (Builder $builder) use ($request) {
            $builder->getModel()->katalaluan = Hash::make($request->input('ahli.katalaluan'));
        });

        $ahli
            ->fill($request->collect('ahli')->except(['katalaluan'])->toArray())
            ->save();

        Toast::info(__('Ahli was updated.'));

        return redirect()->route('kehadiran.ahli');
    }

    public function remove(Request $request): void
    {
        $itemToRemove = Ahli::findOrFail($request->get('id'));

        $itemToRemove->delete();

        Toast::info(__('Ahli was removed'));
    }

    /**
     * @return array
     */
    public function asyncGetAhli(Ahli $ahli): iterable
    {
        return [
            'ahli' => $ahli,
        ];
    }
}
