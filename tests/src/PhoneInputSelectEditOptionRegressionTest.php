<?php

use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputContact;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\TestCase;

use function Pest\Livewire\livewire;

uses(TestCase::class);

it('does not throw when edit option is submitted repeatedly for a relation select with phone input', function (): void {
    $relatedUser = FilamentPhoneInputUser::create([
        'name' => 'Select Edit Contact',
        'email' => fake()->unique()->safeEmail(),
        'password' => bcrypt('password'),
        'phone' => '+905300000000',
    ]);

    livewire(CreatePhoneInputSelectEditOptionContact::class)
        ->fillForm([
            'user_id' => $relatedUser->id,
        ])
        ->callFormComponentAction('user_id', 'editOption', [
            'phone' => '+905301111111',
        ])
        ->assertHasNoFormComponentActionErrors()
        ->callFormComponentAction('user_id', 'editOption', [
            'phone' => '+905302222222',
        ])
        ->assertHasNoFormComponentActionErrors();

    expect($relatedUser->refresh()->phone)->toBe('+905302222222');
});

class PhoneInputSelectEditOptionContactResource extends Resource
{
    protected static ?string $model = FilamentPhoneInputContact::class;

    protected static ?string $slug = 'select-edit-option-contacts';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->relationship(name: 'user', titleAttribute: 'name')
                ->required()
                ->editOptionForm([
                    PhoneInput::make('phone')
                        ->displayNumberFormat(PhoneInputNumberType::E164)
                        ->formatAsYouType(false)
                        ->required(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPhoneInputSelectEditOptionContacts::route('/'),
            'create' => CreatePhoneInputSelectEditOptionContact::route('/create'),
        ];
    }
}

class ListPhoneInputSelectEditOptionContacts extends ListRecords
{
    public static string $resource = PhoneInputSelectEditOptionContactResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

class CreatePhoneInputSelectEditOptionContact extends CreateRecord
{
    public static string $resource = PhoneInputSelectEditOptionContactResource::class;

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
