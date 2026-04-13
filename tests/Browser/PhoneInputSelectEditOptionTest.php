<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputContact;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUser;

class PhoneInputSelectEditOptionTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputSelectEditOptionBrowserResource::class;

    #[Test]
    public function it_can_submit_relation_edit_option_twice_without_throwing_exception(): void
    {
        $relatedUser = FilamentPhoneInputUser::create([
            'name' => 'Browser Edit Contact',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'phone' => '+905300000000',
        ]);

        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('#form\\.user_id')
                ->select('#form\\.user_id', (string) $relatedUser->id)
                ->pause(350)
                ->assertPresent('button[title="Edit related user"]')
                ->click('button[title="Edit related user"]')
                ->waitForText('Edit related user')
                ->waitFor('input[type="tel"]')
                ->pause(300)
                ->clear('input[type="tel"]')
                ->typeSlowly('input[type="tel"]', '+905301111111')
                ->press('Save')
                ->waitUntilMissing('input[type="tel"]')
                ->pause(350)
                ->click('button[title="Edit related user"]')
                ->waitFor('input[type="tel"]')
                ->pause(300)
                ->clear('input[type="tel"]')
                ->typeSlowly('input[type="tel"]', '+905302222222')
                ->press('Save')
                ->waitUntilMissing('input[type="tel"]')
                ->assertDontSee('ActionNotResolvableException')
        );

        $this->assertDatabaseHas('users', [
            'id' => $relatedUser->id,
            'phone' => '+905302222222',
        ]);
    }
}

class PhoneInputSelectEditOptionBrowserResource extends Resource
{
    protected static ?string $model = FilamentPhoneInputContact::class;

    protected static ?string $slug = 'phone-input-select-edit-option-browser';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->native(true)
                ->relationship(name: 'user', titleAttribute: 'name')
                ->required()
                ->editOptionModalHeading('Edit related user')
                ->editOptionAction(fn (Action $action): Action => $action->label('Edit related user'))
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
            'index' => ListPhoneInputSelectEditOptionBrowserContacts::route('/'),
            'create' => CreatePhoneInputSelectEditOptionBrowserContact::route('/create'),
        ];
    }
}

class ListPhoneInputSelectEditOptionBrowserContacts extends ListRecords
{
    public static string $resource = PhoneInputSelectEditOptionBrowserResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

class CreatePhoneInputSelectEditOptionBrowserContact extends CreateRecord
{
    public static string $resource = PhoneInputSelectEditOptionBrowserResource::class;

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
