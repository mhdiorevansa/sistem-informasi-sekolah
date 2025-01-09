<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BebanMengajarResource\Pages;
use App\Filament\Resources\BebanMengajarResource\RelationManagers;
use App\Models\BebanMengajar;
use App\Models\JadwalMataPelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BebanMengajarResource extends Resource
{
    protected static ?string $model = JadwalMataPelajaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Manajemen Guru';
    protected static ?string $navigationLabel = 'Beban Mengajar';
    protected static ?string $slug = 'beban-mengajar';
    protected static ?string $label = 'Beban Mengajar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guru.nama_guru'),
                TextColumn::make('total_jam_kerja')
                ->label('Total Jam Kerja')
                ->formatStateUsing(function ($state) {
                    return \number_format($state, 1) . ' Jam';
                }),
                TextColumn::make('total_jadwal')
                ->label('Total Ngajar')
                ->formatStateUsing(function ($state) {
                    return $state . ' Kali';
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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

    public static function getEloquentQuery(): Builder
    {
        return JadwalMataPelajaran::selectRaw('MIN(id) AS id, guru_id, SUM(EXTRACT(EPOCH FROM (waktu_selesai - waktu_mulai)) / 3600) AS total_jam_kerja, COUNT(waktu_mulai) AS total_jadwal')
            ->groupBy('guru_id')
            ->orderBy('id', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBebanMengajars::route('/'),
            // 'create' => Pages\CreateBebanMengajar::route('/create'),
            // 'edit' => Pages\EditBebanMengajar::route('/{record}/edit'),
        ];
    }
}
