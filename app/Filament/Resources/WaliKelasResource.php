<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaliKelasResource\Pages;
use App\Filament\Resources\WaliKelasResource\RelationManagers;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\WaliKelas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WaliKelasResource extends Resource
{
    protected static ?string $model = WaliKelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Manajemen Guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(fn() => Kelas::whereNotIn('id', WaliKelas::all()->pluck('kelas_id'))->orderBy('tingkatan', 'asc')->pluck('nama_kelas', 'id'))
                    ->placeholder('Pilih Kelas')
                    ->rules([
                        'unique:wali_kelas,kelas_id'
                    ])
                    ->validationMessages([
                        'unique' => 'Kelas ini sudah memiliki wali kelas',
                    ])
                    ->searchable()
                    ->required(),
                Select::make('guru_id')
                    ->label('Guru')
                    ->options(Guru::all()->pluck('nama_guru', 'id'))
                    ->placeholder('Pilih Guru')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kelas.nama_kelas')
                    ->label('Nama Kelas')
                    ->formatStateUsing(fn ($record) => 'Kelas ' . $record->kelas->nama_kelas)
                    ->searchable(),
                TextColumn::make('guru.nama_guru')
                    ->label('Nama Guru')
                    ->searchable(),
                TextColumn::make('guru.nip')
                    ->label('NIP Guru')
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
            'index' => Pages\ListWaliKelas::route('/'),
            // 'create' => Pages\CreateWaliKelas::route('/create'),
            // 'edit' => Pages\EditWaliKelas::route('/{record}/edit'),
        ];
    }
}
