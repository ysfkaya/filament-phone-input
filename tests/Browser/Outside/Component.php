<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser\Outside;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\View;
use Livewire\Component as Livewire;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class Component extends Livewire implements HasForms
{
    use InteractsWithForms;

    public $data;

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                PhoneInput::make('phone'),
            ])->statePath('data');
    }

    public function render()
    {
        return View::file(__DIR__.'/view.blade.php');
    }
}
