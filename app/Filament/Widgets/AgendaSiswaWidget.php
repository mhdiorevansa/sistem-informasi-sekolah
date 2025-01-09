<?php

namespace App\Filament\Widgets;

use App\Models\AgendaSiswa;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class AgendaSiswaWidget extends FullCalendarWidget
{
    public Model | string | null $model = AgendaSiswa::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return AgendaSiswa::where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (AgendaSiswa $task) {
                return [
                    'id'    => $task->id,
                    'title' => $task->nama_agenda,
                    'start' => $task->start,
                    'end'   => $task->end,
                ];
            })
            ->toArray();
    }

    public static function canView(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('nama_agenda')
                ->label('Nama Agenda')
                ->required(),
            DateTimePicker::make('start')
                ->label('Waktu Mulai')
                ->required(),
            DateTimePicker::make('end')
                ->label('Waktu Selesai')
                ->required(),
        ];
    }
}