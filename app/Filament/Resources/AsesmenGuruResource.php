<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsesmenGuruResource\Pages;
use App\Filament\Resources\AsesmenGuruResource\RelationManagers;
use App\Models\AsesmenGuru;
use App\Models\Guru;
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

class AsesmenGuruResource extends Resource
{
    protected static ?string $model = AsesmenGuru::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Manajemen Guru';
    protected static ?string $slug = 'asesmen-guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('guru_id')
                    ->options(fn() => Guru::whereNotIn('id', AsesmenGuru::all()->pluck('guru_id'))->pluck('nama_guru', 'id'))
                    ->label('Nama Guru')
                    ->required(),
                TextInput::make('kedisiplinan')
                    ->label('Nilai Kedisiplinan')
                    ->numeric()
                    ->required(),
                TextInput::make('etika')
                    ->label('Nilai Etika')
                    ->numeric()
                    ->required(),
                TextInput::make('tanggung_jawab')
                    ->label('Nilai Tanggung Jawab')
                    ->numeric()
                    ->required(),
                TextInput::make('kreatifitas')
                    ->label('Nilai Kreatifitas')
                    ->numeric()
                    ->required(),
                TextInput::make('komunikasi')
                    ->label('Nilai Komunikasi')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guru.nama_guru')
                    ->label('Nama Guru')
                    ->searchable(),
                TextColumn::make('kedisiplinan')
                    ->label('Kedisiplinan'),
                TextColumn::make('etika')
                    ->label('Etika'),
                TextColumn::make('tanggung_jawab')
                    ->label('Tanggung Jawab'),
                TextColumn::make('kreatifitas')
                    ->label('Kreatifitas'),
                TextColumn::make('komunikasi')
                    ->label('Komunikasi'),
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
            'index' => Pages\ListAsesmenGurus::route('/'),
            // 'create' => Pages\CreateAsesmenGuru::route('/create'),
            // 'edit' => Pages\EditAsesmenGuru::route('/{record}/edit'),
        ];
    }
}
