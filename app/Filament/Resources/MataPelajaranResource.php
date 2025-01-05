<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MataPelajaranResource\Pages;
use App\Filament\Resources\MataPelajaranResource\RelationManagers;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?string $slug = 'mata-pelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->placeholder('Masukkan Mata Pelajaran')
                    ->required(),
                Select::make('pengampu')
                    ->label('Pengampu')
                    ->options(Guru::all()->pluck('nama_guru', 'id'))
                    ->placeholder('Pilih Pengampu')
                    ->searchable()
                    ->required(),
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(Kelas::orderBy('tingkatan', 'asc')->pluck('nama_kelas', 'id'))
                    ->placeholder('Pilih Kelas')
                    ->searchable()
                    ->required(),
                TextInput::make('kode')
                    ->label('Kode Mata Pelajaran')
                    ->placeholder('Masukkan Kode Mata Pelajaran')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'kelas.nama_kelas',
            ])
            ->defaultGroup('kelas.nama_kelas')
            ->columns([
                TextColumn::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                TextColumn::make('guru.nama_guru')
                    ->label('Pengampu')
                    ->searchable(),
                TextColumn::make('kode')
                    ->label('Kode')
                    ->searchable(),
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
            'index' => Pages\ListMataPelajarans::route('/'),
            // 'create' => Pages\CreateMataPelajaran::route('/create'),
            // 'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
