<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SppResource\Pages;
use App\Filament\Resources\SppResource\RelationManagers;
use App\Models\Spp;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SppResource extends Resource
{
    protected static ?string $model = Spp::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?string $navigationLabel = 'Data SPP';
    protected static ?string $slug = 'data-spp';
    protected static ?string $label = 'Data SPP';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('harga_spp')
                    ->label('Harga SPP')
                    ->numeric()
                    ->required(),
                DatePicker::make('periode')
                    ->label('Periode')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('harga_spp')
                    ->label('Harga SPP')
                    ->searchable()
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('periode')
                    ->label('Periode')
                    ->formatStateUsing(fn($state) => date('d-m-Y', strtotime($state))),
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
            'index' => Pages\ListSpps::route('/'),
            // 'create' => Pages\CreateSpp::route('/create'),
            // 'edit' => Pages\EditSpp::route('/{record}/edit'),
        ];
    }
}
