<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Guru';
    protected static ?string $navigationLabel = 'Data Guru';
    protected static ?string $slug = 'data-guru';
    protected static ?string $label = 'Data Guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_guru')
                    ->label('Nama Guru')
                    ->placeholder('Masukkan Nama Guru')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'pria' => 'pria',
                        'wanita' => 'wanita',
                    ])
                    ->searchable()
                    ->required(),
                TextInput::make('nip')
                    ->label('NIP')
                    ->placeholder('Masukkan NIP')
                    ->numeric()
                    ->required(),
                TextInput::make('nomor_hp')
                    ->label('Nomor Hp')
                    ->placeholder('Masukkan Nomor HP')
                    ->numeric()
                    ->required(),
                TextInput::make('alamat')
                    ->label('Alamat')
                    ->placeholder('Masukkan Alamat')
                    ->required(),
                Select::make('status')
                    ->searchable()
                    ->label('Status')
                    ->options([
                        'aktif' => 'aktif',
                        'tidak aktif' => 'tidak aktif',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_guru')
                    ->label('Nama Guru')
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),
                TextColumn::make('nip')
                    ->label('NIP'),
                TextColumn::make('nomor_hp')
                    ->label('Nomor Hp'),
                TextColumn::make('alamat')
                    ->label('Alamat'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'tidak aktif' => 'danger',
                    })
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
            'index' => Pages\ListGurus::route('/'),
            // 'create' => Pages\CreateGuru::route('/create'),
            // 'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
