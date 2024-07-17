<?php

namespace App\Orchid\Screens\Kehadiran;

use App\Models\Ahli;
use App\Models\Kelas;
use App\Orchid\Layouts\Kehadiran\ChartDonut;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Orchid\Attachment\File;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
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

            'piechart_gender' => Ahli::countForGroup('jantina')->toChart(),

            'piechart_tingkatan' => Kelas::join('ahlis','ahlis.kelas_id', '=', 'kelas.id')
                ->countForGroup('ting','T')->toChart(),

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
            ModalToggle::make('Tambah Ahli')
                ->modal('xpressAddModal')
                ->method('store')
                // ->parameters([
                //     'contactType' => Contact::TYPE_CUSTOMER
                // ])
                ->icon('bs.plus-circle'),

            ModalToggle::make(__('Muat Naik'))
                ->icon('bs.cloud-upload')
                ->modal('xpressBulkUpload')
                ->method('uploadCsv'),
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
            Layout::columns([
                ChartDonut::make('piechart_gender', 'Komposisi Jantina'),
                ChartDonut::make('piechart_tingkatan', 'Jumlah Ahli Mengikut Tingkatan'),
            ]),

            Layout::table('model', [
                TD::make('id', '#')->render(fn ($target, object $loop) => $loop->iteration + (request('page') > 0 ? (request('page') - 1) * $target->getPerPage() : 0)),
                TD::make('nama')->sort()->filter(),
                TD::make('nokp', 'No. K/P')->sort()->filter(),
                TD::make('email', 'E-mel')->sort()->filter(),
                TD::make('kelas_id', 'Kelas')->sort()
                    ->filter(Relation::make()->fromModel(Kelas::class, 'nama_kelas')->searchColumns('ting', 'nama_kelas')->displayAppend('kelasFullName'))
                    ->render(fn ($target) => $target->kelas->kelasFullName ?? null),
                // ->render(fn($target) => $target->kelas->ting . ' ' . $target->kelas->nama_kelas ?? null),

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

            // Bulk upload list with csv
            Layout::modal('xpressBulkUpload', Layout::rows([
                Input::make('csv_file')
                    ->title('csv file')
                    ->type('file'),
            ]))->title('Bulk upload senarai ahli')->rawClick(),

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

                Select::make('ahli.jantina')
                    ->title('Jantina')
                    // ->allowAdd()
                    ->options([
                        1  => 'LELAKI',
                        2  => 'PEREMPUAN',
                    ])
                    ->empty('No select')
                    ->required()
                    ->horizontal(),

                Input::make('ahli.email')
                    ->title('E-mel')
                    // ->required()
                    ->horizontal(),

                Relation::make('ahli.kelas_id')
                    ->fromModel(Kelas::class, 'nama_kelas')
                    ->searchColumns('ting', 'nama_kelas')
                    ->displayAppend('kelasFullName')
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

                Select::make('ahli.jantina')
                    ->title('Jantina')
                    // ->allowAdd()
                    ->options([
                        1  => 'LELAKI',
                        2  => 'PEREMPUAN',
                    ])
                    ->empty('No select')
                    ->required()
                    ->horizontal(),

                Input::make('ahli.email')
                    ->title('E-mel')
                    ->required()
                    ->horizontal(),

                Relation::make('ahli.kelas_id')
                    ->fromModel(Kelas::class, 'nama_kelas')
                    ->searchColumns('ting', 'nama_kelas')
                    ->displayAppend('kelasFullName')
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
        $request->validate([
            'ahli.nokp' => [
                'required',
                Rule::unique(Ahli::class, 'nokp')->ignore($ahli)
            ],
            'ahli.email' => [
                // 'required',
                Rule::unique(Ahli::class, 'email')->ignore($ahli),
            ],
        ]);

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
        $request->validate([
            'ahli.nokp' => [
                'required',
                Rule::unique(Ahli::class, 'nokp')->ignore($ahli)
            ],
            'ahli.email' => [
                'required',
                Rule::unique(Ahli::class, 'email')->ignore($ahli),
            ],
        ]);

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

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // 
        $file = $request->file('csv_file');
        
        // // for debugging
        // $mimeType = $file->getMimeType();
        // $extension = $file->getClientOriginalExtension();
        
        // // Log the values for debugging
        // Log::info("MIME type: $mimeType, Extension: $extension");
        
        // save csv file
        // $file->storeAs('public/csv/uploads', $file->hashName());

        //read csv file and skip data
        $handle = fopen($file->path(), 'r');

        //skip the header row
        fgetcsv($handle);


        $chunksize = 25;


        while (!feof($handle)) {
            $chunkdata = [];

            for ($i = 0; $i < $chunksize; $i++) {
                $data = fgetcsv($handle);
                if ($data === false) {
                    break;
                }
                
                // Trim each column value
                $trimmedData = array_map('trim', $data);
                $chunkdata[] = $trimmedData;
                // $chunkdata[] = $data;
            }

            $this->processChunkData($chunkdata);
        }
        fclose($handle);

        Toast::info(__('Bulk senarai ahli was saved'));

        return redirect()->back()->with('success', 'Data has been added successfully.');
        // return redirect()->route('kehadiran.ahli')->with('success', 'Data has been added successfully.');
    }

    public function processChunkData($chunkdata)
    {
        foreach ($chunkdata as $column) {
            // Extract column values
            [$tingkatan, $namaKelas, $nokp, $namaAhli, $jantina, $email, $katalaluan] = $column;

            // Create or retrieve Kelas
            $kelas = Kelas::firstOrCreate([
                'ting' => $tingkatan,
                'nama_kelas' => $namaKelas,
            ]);

            // Find existing Ahli by nokp or create a new one
            $ahli = Ahli::firstOrNew(['nokp' => $nokp]);
            $ahli->kelas_id = $kelas->id;
            $ahli->nama = $namaAhli;
            $ahli->jantina = $jantina;
            $ahli->email = $email;
            $ahli->katalaluan = $katalaluan;
            $ahli->save();
        }
    }
}
