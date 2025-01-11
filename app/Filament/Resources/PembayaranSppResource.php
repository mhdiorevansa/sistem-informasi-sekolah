<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranSppResource\Pages;
use App\Filament\Resources\PembayaranSppResource\RelationManagers;
use App\Models\DataSiswa;
use App\Models\PembayaranSpp;
use App\Models\Spp;
use Carbon\Carbon;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranSppResource extends Resource
{
    protected static ?string $model = PembayaranSpp::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Manajemen Siswa';
    protected static ?string $slug = 'pembayaran-spp';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(fn() => DataSiswa::pluck('nama_lengkap', 'id'))
                    ->required(),
                Select::make('periode_spp')
                    ->label('Periode SPP')
                    ->options(
                        fn() => Spp::all()
                            ->mapWithKeys(fn($spp) => [$spp->id => Carbon::parse($spp->periode)->format('d/m/Y')])
                    )
                    ->required(),
                TextInput::make('jumlah_bayar')
                    ->label('Jumlah Bayar')
                    ->required(),
                DatePicker::make('tanggal_bayar')
                    ->label('Tanggal Bayar')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama_lengkap')
                    ->label('Nama Siswa'),
                TextColumn::make('siswa.kelas.nama_kelas')
                    ->label('Kelas Siswa'),
                TextColumn::make('spp.periode')
                    ->formatStateUsing(fn($state) => date('d-m-Y', strtotime($state)))
                    ->label('Periode'),
                TextColumn::make('jumlah_bayar')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->label('Jumlah Bayar'),
                TextColumn::make('status_bayar')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'Belum Lunas' => 'danger',
                    })
                    ->label('Status Bayar'),
            ])
            ->filters([
                SelectFilter::make('status_bayar')
                    ->options([
                        'Lunas' => 'Lunas',
                        'Belum Lunas' => 'Belum Lunas',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (PembayaranSpp $record, array $data): PembayaranSpp {
                        $periodeSpp = $data['periode_spp'];
                        $spp = Spp::where('id', $periodeSpp)->value('harga_spp');
                        $statusBayar = $data['jumlah_bayar'] >= $spp ? 'Lunas' : 'Belum Lunas';
                        $record->update([
                            'siswa_id' => $data['siswa_id'],
                            'periode_spp' => $periodeSpp,
                            'jumlah_bayar' => $data['jumlah_bayar'],
                            'tanggal_bayar' => $data['tanggal_bayar'],
                            'status_bayar' => $statusBayar,
                        ]);
                        return $record;
                    }),
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
            'index' => Pages\ListPembayaranSpps::route('/'),
            // 'create' => Pages\CreatePembayaranSpp::route('/create'),
            // 'edit' => Pages\EditPembayaranSpp::route('/{record}/edit'),
        ];
    }
}
