<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanSiswaResource\Pages;
use App\Filament\Resources\LaporanSiswaResource\RelationManagers;
use App\Models\Alumni;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\LaporanSiswa;
use App\Models\MataPelajaran;
use App\Models\NilaiLaporanSiswa;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanSiswaResource extends Resource
{
    protected static ?string $model = LaporanSiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?string $slug = 'raport-siswa';
    protected static ?string $navigationLabel = 'Raport Siswa';
    protected static ?string $label = 'Raport Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->placeholder('Pilih Kelas')
                    ->options(Kelas::all()->pluck('nama_kelas', 'id'))
                    ->reactive()
                    ->disabled()
                    ->searchable()
                    ->dehydrated()
                    ->required(),
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->placeholder('Pilih Siswa')
                    ->relationship('siswa', 'nama_lengkap')
                    ->disabled()
                    ->searchable()
                    ->dehydrated()
                    ->required(),
                TextInput::make('semester')
                    ->label('Semester')
                    ->placeholder('Masukkan Semester')
                    ->reactive()
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->placeholder('Pilih Status')
                    ->options(function (LaporanSiswa $record) {
                        if ($record->kelas->nama_kelas === 'VI') {
                            $options = [
                                'lulus' => 'Lulus',
                                'tidak lulus' => 'Tidak Lulus',
                            ];
                        } else if ($record->kelas->nama_kelas != 'VI') {
                            $options = [
                                'belum naik kelas' => 'Belum Naik Kelas',
                                'naik kelas' => 'Naik Kelas',
                                'tidak naik kelas' => 'Tidak Naik Kelas',
                            ];
                        }
                        return $options;
                    })
                    ->searchable()
                    ->disabled(function ($get) {
                        return $get('semester') != '2';
                    })
                    ->required(),
                Repeater::make('nilaiLaporanSiswa')
                    ->relationship()
                    ->schema([
                        Select::make('mata_pelajaran_id')
                            ->options(function () {
                                return MataPelajaran::with('kelas')
                                    ->get()
                                    ->groupBy('kelas.nama_kelas')
                                    ->sortBy(function ($mataPelajaran, $kelasNama) {
                                        return $mataPelajaran->first()->kelas->tingkatan;
                                    })
                                    ->mapWithKeys(function ($mataPelajaran, $kelasNama) {
                                        $label = "Kelas $kelasNama";
                                        return [
                                            $label => $mataPelajaran->pluck('mata_pelajaran', 'id')->toArray(),
                                        ];
                                    })
                                    ->toArray();
                            })
                            ->label('Mata Pelajaran')
                            ->placeholder('Pilih Mata Pelajaran')
                            ->searchable()
                            ->required(),
                        TextInput::make('nilai')
                            ->label('Nilai')
                            ->placeholder('Masukkan Nilai')
                            ->required(),
                        TextInput::make('keaktifan')
                            ->label('Keaktifan')
                            ->placeholder('Masukkan Nilai Keaktifan')
                            ->required(),
                        TextInput::make('alfa')
                            ->label('Alfa')
                            ->placeholder('Masukkan Jumlah Alfa')
                            ->required(),
                        TextInput::make('izin')
                            ->label('Izin')
                            ->placeholder('Masukkan Jumlah Izin')
                            ->required(),
                        TextInput::make('sakit')
                            ->label('Sakit')
                            ->placeholder('Masukkan Jumlah Sakit')
                            ->required(),
                    ])
                    ->columns(2)->columnSpan(2)
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return LaporanSiswa::whereNotIn('status', ['naik kelas', 'lulus']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'kelas.nama_kelas'
            ])
            ->defaultGroup('kelas.nama_kelas')
            ->columns([
                TextColumn::make('siswa.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable(),
                TextColumn::make('siswa.nis')
                    ->label('NIS')
                    ->searchable(),
                TextColumn::make('nilaiLaporanSiswa.nilai')
                    ->default('0')
                    ->label('Nilai Siswa')
                    ->formatStateUsing(function ($state, $record) {
                        if (is_string($state)) {
                            $values = explode(', ', $state);
                            $totalNilai = array_sum(array_map('intval', $values));
                            $jumlahMataPelajaran = $record->nilaiLaporanSiswa->count();
                            $rataRataNilai = $jumlahMataPelajaran > 0 ? $totalNilai / $jumlahMataPelajaran : 0;
                            return \number_format($rataRataNilai, 2);
                        }
                        return 0;
                    }),
                TextColumn::make('semester')
                    ->label('Semester'),
            ])
            ->filters([
                SelectFilter::make('semester')
                    ->label('Semester')
                    ->options([
                        '1' => '1',
                        '2' => '2',
                    ])
                    ->default('1'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (LaporanSiswa $record, array $data): LaporanSiswa {
                        $record->update($data);
                        if ($record->status === 'naik kelas') {
                            $siswaId = $record->siswa_id;
                            LaporanSiswa::where('siswa_id', $siswaId)->update([
                                'status' => 'naik kelas'
                            ]);
                            $dataSiswa = DataSiswa::find($siswaId);
                            $currentKelasId = $dataSiswa->kelas_id;
                            $currentKelas = Kelas::find($currentKelasId);
                            $nextKelas = Kelas::where('tingkatan', $currentKelas->tingkatan + 1)->first();
                            if ($nextKelas) {
                                $dataSiswa->kelas_id = $nextKelas->id;
                                $dataSiswa->save();
                                for ($i = 1; $i <= 2; $i++) {
                                    LaporanSiswa::create([
                                        'siswa_id' => $siswaId,
                                        'semester' => $i,
                                        'status' => 'belum naik kelas',
                                        'kelas_id' => $nextKelas->id,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                };
                            }
                        } else if ($record->status === 'lulus') {
                            $siswaId = $record->siswa_id;
                            LaporanSiswa::where('siswa_id', $siswaId)->update([
                                'status' => 'lulus'
                            ]);
                            Alumni::create([
                                'siswa_id' => $siswaId
                            ]);
                        }
                        return $record;
                    }),
                Action::make('raport')
                    ->label('Raport')
                    ->color('info')
                    ->icon('heroicon-o-document-text')
                    ->modalHeading('Raport Siswa')
                    ->modalWidth('4xl')
                    ->modalContent(function (LaporanSiswa $record) {
                        return view('filament.pages.laporan-siswa', [
                            'groupedRaports' => $record->siswa->laporanSiswa
                                ->load('nilaiLaporanSiswa')
                                ->groupBy(fn($raport) => $raport->kelas->nama_kelas . ' - Semester ' . $raport->semester),
                            'siswa' => $record->siswa,
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
                // Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanSiswas::route('/'),
            // 'create' => Pages\CreateLaporanSiswa::route('/create'),
            // 'edit' => Pages\EditLaporanSiswa::route('/{record}/edit'),
        ];
    }
}
