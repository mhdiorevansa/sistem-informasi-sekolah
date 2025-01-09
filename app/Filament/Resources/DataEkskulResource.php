<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataEkskulResource\Pages;
use App\Filament\Resources\DataEkskulResource\RelationManagers;
use App\Models\EkstrakurikulerSiswa;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataEkskulResource extends Resource
{
    protected static ?string $model = EkstrakurikulerSiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Manajemen Siswa';
    protected static ?string $slug = 'data-ekskul';
    protected static ?string $navigationLabel = 'Data Ekskul';

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
                TextColumn::make('ekstrakurikuler.nama_ekstrakurikuler')
                    ->searchable()
                    ->label('Ekstrakurikuler'),
                TextColumn::make('siswa_list')
                    ->label('Nama Siswa')
                    ->formatStateUsing(function ($state): string {
                        return $state ?? '-';
                    })
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->action(function (EkstrakurikulerSiswa $record, Action $action) {
                        try {
                            EkstrakurikulerSiswa::where('ekstrakurikuler_id', $record->ekstrakurikuler_id)
                                ->delete();
                            $record->delete();
                            $action->success();
                        } catch (\Throwable $th) {
                            $action->failure();
                            return;
                        }
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('Data berhasil dihapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return EkstrakurikulerSiswa::query()
            ->join('data_siswa', 'ekstrakurikuler_siswa.siswa_id', '=', 'data_siswa.id')
            ->selectRaw('MIN(ekstrakurikuler_siswa.id) as id, ekstrakurikuler_siswa.ekstrakurikuler_id, STRING_AGG(data_siswa.nama_lengkap, \', \') as siswa_list')
            ->with('ekstrakurikuler')
            ->groupBy('ekstrakurikuler_siswa.ekstrakurikuler_id')
            ->orderBy('id');
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
            'index' => Pages\ListDataEkskuls::route('/'),
            // 'create' => Pages\CreateDataEkskul::route('/create'),
            // 'edit' => Pages\EditDataEkskul::route('/{record}/edit'),
        ];
    }
}
