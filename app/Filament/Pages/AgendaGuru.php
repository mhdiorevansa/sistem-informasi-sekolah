<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Form;

class AgendaGuru extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Guru';
    protected static ?string $navigationLabel = 'Agenda Guru';
    protected static ?string $slug = 'agenda-guru';
    protected static string $view = 'filament.pages.agenda-guru';
}