<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataSiswaResource\Pages;
use App\Filament\Resources\DataSiswaResource\RelationManagers;
use App\Models\DataSiswa;
use App\Models\Ekstrakurikuler;
use App\Models\EkstrakurikulerSiswa;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataSiswaResource extends Resource
{
    protected static ?string $model = DataSiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Manajemen Siswa';
    protected static ?string $slug = 'data-siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->placeholder('Masukkan Nama Lengkap')
                    ->required(),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'pria' => 'pria',
                        'wanita' => 'wanita',
                    ])
                    ->searchable()
                    ->required(),
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->searchable()
                    ->options(Kelas::orderBy('tingkatan', 'asc')->pluck('nama_kelas', 'id'))
                    ->placeholder('Pilih Kelas')
                    ->required(),
                TextInput::make('nis')
                    ->label('NIS')
                    ->placeholder('Masukkan NIS')
                    ->numeric()
                    ->required(),
                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->placeholder('Masukkan Tanggal Lahir')
                    ->required(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return DataSiswa::doesntHave('alumni')
            ->join('kelas', 'data_siswa.kelas_id', '=', 'kelas.id')
            ->orderBy('kelas.tingkatan', 'asc')
            ->select('data_siswa.*');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'kelas.nama_kelas',
                'gender'
            ])
            ->defaultGroup('kelas.nama_kelas')
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable(),
                TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir'),
                TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas'),
                TextColumn::make('gender')
                    ->label('Gender'),
            ])
            ->filters([
                SelectFilter::make('kelas_id')
                    ->relationship('kelas', 'nama_kelas')
                    ->label('Kelas')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('ekstrakurikulerSiswa')
                    ->label('Ekskul')
                    ->modalHeading(function (DataSiswa $record) {
                        return 'Ekskul ' . $record->nama_lengkap;
                    })
                    ->icon('heroicon-o-clipboard-document-check')
                    ->modalWidth('md')
                    ->form([
                        CheckboxList::make('ekskulId')
                            ->label('PIlih Ekskul')
                            ->options(Ekstrakurikuler::query()->pluck('nama_ekstrakurikuler', 'id'))
                            ->default(fn (DataSiswa $record): array => $record->ekstrakurikuler->pluck('id')->toArray())
                            ->required(),
                    ])
                    ->action(function (array $data, DataSiswa $record, Action $action): void {
                        try {
                            $record->ekstrakurikuler()->sync($data['ekskulId']);
                            $action->success();
                        } catch (\Throwable $th) {
                            $action->failure();
                            return;
                        }
                    })
                    ->successNotificationTitle('Data berhasil disimpan'),
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
            'index' => Pages\ListDataSiswas::route('/'),
            // 'create' => Pages\CreateDataSiswa::route('/create'),
            // 'edit' => Pages\EditDataSiswa::route('/{record}/edit'),
        ];
    }
}
