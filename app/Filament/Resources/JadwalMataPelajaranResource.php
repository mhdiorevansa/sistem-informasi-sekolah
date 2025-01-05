<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalMataPelajaranResource\Pages;
use App\Filament\Resources\JadwalMataPelajaranResource\RelationManagers;
use App\Models\Guru;
use App\Models\JadwalMataPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalMataPelajaranResource extends Resource
{
    protected static ?string $model = JadwalMataPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?string $slug = 'jadwal-mapel';
    protected static ?string $navigationLabel = 'Jadwal Pelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('hari')
                    ->label('Hari')
                    ->options([
                        'senin' => 'Senin',
                        'selasa' => 'Selasa',
                        'rabu' => 'Rabu',
                        'kamis' => 'Kamis',
                        'jumat' => 'Jumat',
                        'sabtu' => 'Sabtu',
                    ])
                    ->reactive()
                    ->searchable()
                    ->required(),
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(function () {
                        return Kelas::orderBy('tingkatan', 'asc')->pluck('nama_kelas', 'id');
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $set('mata_pelajaran_id', null);
                    })
                    ->searchable()
                    ->placeholder('Pilih Kelas')
                    ->required(),
                Select::make('mata_pelajaran_id')
                    ->label('Mata Pelajaran')
                    ->options(function ($get) {
                        $kelasId = $get('kelas_id');
                        return $kelasId
                            ? MataPelajaran::with('kelas')
                            ->where('kelas_id', $kelasId)
                            ->pluck('mata_pelajaran', 'id')
                            : [];
                    })
                    ->placeholder('Pilih Kelas Terlebih Dahulu')
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        if ($state) {
                            $mataPelajaran = MataPelajaran::with('guru')->find($state);
                            if ($mataPelajaran && $mataPelajaran->guru) {
                                $set('guru_id', $mataPelajaran->guru->id);
                            } else {
                                $set('guru_id', null);
                            }
                        } else {
                            $set('guru_id', null);
                        }
                    })
                    ->required(),
                Select::make('guru_id')
                    ->label('Guru')
                    ->options(function ($get) {
                        $mataPelajaranId = $get('mata_pelajaran_id');
                        if ($mataPelajaranId) {
                            $mataPelajaran = MataPelajaran::with('guru')->find($mataPelajaranId);
                            if ($mataPelajaran && $mataPelajaran->guru) {
                                return [
                                    $mataPelajaran->guru->id => $mataPelajaran->guru->nama_guru
                                ];
                            }
                        }
                        return [];
                    })
                    ->searchable()
                    ->placeholder('Pilih Mata Pelajaran Terlebih Dahulu')
                    ->required(),
                TimePicker::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->required()
                    ->afterStateUpdated(function ($state, $get, $set) {
                        $kelasId = $get('kelas_id');
                        $hari = $get('hari');
                        $waktuSelesai = $get('waktu_selesai');

                        if ($kelasId && $hari && $state && $waktuSelesai) {
                            $exists = JadwalMataPelajaran::where('hari', $hari)
                                ->where('kelas_id', $kelasId)
                                ->whereTime('waktu_mulai', '<=', $waktuSelesai)
                                ->whereTime('waktu_selesai', '>=', $state)
                                ->exists();

                            if ($exists) {
                                Notification::make()
                                    ->title('Jadwal Mata Pelajaran Bentrok Dengan Mata Pelajaran Lain')
                                    ->danger()
                                    ->send();

                                $set('waktu_mulai', null);
                            }
                        }
                    }),
                TimePicker::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function ($state, $get, $set) {
                        $kelasId = $get('kelas_id');
                        $hari = $get('hari');
                        $waktuMulai = $get('waktu_mulai');

                        if ($kelasId && $hari && $waktuMulai && $state) {
                            $exists = JadwalMataPelajaran::where('hari', $hari)
                                ->where('kelas_id', $kelasId)
                                ->whereTime('waktu_mulai', '<=', $state)
                                ->whereTime('waktu_selesai', '>=', $waktuMulai)
                                ->exists();

                            if ($exists) {
                                Notification::make()
                                    ->title('Jadwal Mata Pelajaran Bentrok Dengan Mata Pelajaran Lain')
                                    ->danger()
                                    ->send();

                                $set('waktu_selesai', null);
                            }
                        }
                    }),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return JadwalMataPelajaran::join('kelas', 'jadwal_mata_pelajaran.kelas_id', '=', 'kelas.id')
            ->orderBy('hari', 'desc')
            ->orderBy('kelas.tingkatan', 'asc')
            ->select('jadwal_mata_pelajaran.*');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'hari'
            ])
            ->defaultGroup('hari')
            ->columns([
                TextColumn::make('kelas.nama_kelas')
                    ->formatStateUsing(fn($record) => 'kelas ' . $record->kelas->nama_kelas)
                    ->label('Kelas'),
                TextColumn::make('mataPelajaran.mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                TextColumn::make('guru.nama_guru')
                    ->label('Guru')
                    ->searchable(),
                TextColumn::make('waktu_mulai')
                    ->label('Waktu Mulai'),
                TextColumn::make('waktu_selesai')
                    ->label('Waktu Selesai'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListJadwalMataPelajarans::route('/'),
            // 'create' => Pages\CreateJadwalMataPelajaran::route('/create'),
            // 'edit' => Pages\EditJadwalMataPelajaran::route('/{record}/edit'),
        ];
    }
}
