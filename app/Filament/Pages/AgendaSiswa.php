<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AgendaSiswa extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Siswa';
    protected static ?string $navigationLabel = 'Agenda Siswa';
    protected static ?string $slug = 'agenda-siswa';
    protected static string $view = 'filament.pages.agenda-siswa';
}
