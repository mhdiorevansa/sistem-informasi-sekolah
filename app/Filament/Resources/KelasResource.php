<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\WaliKelas;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Manajemen Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->placeholder('Masukkan Nama Kelas')
                    ->columnSpan([
                        'default' => 2
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->searchable(),
                TextColumn::make('jumlah_siswa')
                    ->label('Jumlah Siswa')
                    ->getStateUsing(function ($record) {
                        return DataSiswa::where('kelas_id', $record->id)->count();
                    })
                    ->default(0),
                TextColumn::make('guru.nama_guru')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->default('-'),
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
            'index' => Pages\ListKelas::route('/'),
            // 'create' => Pages\CreateKelas::route('/create'),
            // 'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
