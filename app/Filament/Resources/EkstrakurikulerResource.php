<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EkstrakurikulerResource\Pages;
use App\Filament\Resources\EkstrakurikulerResource\RelationManagers;
use App\Models\Ekstrakurikuler;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EkstrakurikulerResource extends Resource
{
    protected static ?string $model = Ekstrakurikuler::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?string $slug = 'ekstrakurikuler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_ekstrakurikuler')
                    ->label('Nama Ekstrakurikuler')
                    ->placeholder('Masukkan Nama Ekstrakurikuler')
                    ->required(),
                TextInput::make('keterangan')
                    ->label('Keterangan Ekstrakurikuler')
                    ->placeholder('Masukkan eterangan Ekstrakurikuler')
                    ->required(),
                TextInput::make('pengampu')
                    ->label('Nama Pengampu')
                    ->placeholder('Masukkan Nama Pengampu')
                    ->required(),
                Select::make('waktu_ekstrakurikuler')
                    ->label('Waktu Ekstrakurikuler')
                    ->searchable()
                    ->options([
                        'senin' => 'Senin',
                        'selasa' => 'Selasa',
                        'rabu' => 'Rabu',
                        'kamis' => 'Kamis',
                        'jumat' => 'Jumat',
                        'sabtu' => 'Sabtu',
                    ])
                    ->required(),
                TimePicker::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->required(),
                TimePicker::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_ekstrakurikuler')
                    ->label('Nama Ekstrakurikuler')
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable(),
                TextColumn::make('pengampu')
                    ->label('Pengampu')
                    ->searchable(),
                TextColumn::make('waktu_ekstrakurikuler')
                    ->label('Jadwal'),
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
            'index' => Pages\ListEkstrakurikulers::route('/'),
            // 'create' => Pages\CreateEkstrakurikuler::route('/create'),
            // 'edit' => Pages\EditEkstrakurikuler::route('/{record}/edit'),
        ];
    }
}
