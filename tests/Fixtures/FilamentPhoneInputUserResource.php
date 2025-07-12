<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Pages\CreateFilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Pages\EditFilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Pages\ListFilamentPhoneInputUsers;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Schemas\FilamentPhoneInputUserForm;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Tables\FilamentPhoneInputUsersTable;

class FilamentPhoneInputUserResource extends Resource
{
    protected static ?string $model = FilamentPhoneInputUser::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static $phoneInputCallback = null;

    protected static $phoneTableColumn = null;

    protected static ?string $slug = 'users';

    public static function phoneInput(?callable $callback = null): void
    {
        self::$phoneInputCallback = $callback;
    }

    public static function getPhoneInput(): ?PhoneInput
    {
        $callback = self::$phoneInputCallback ?: function (PhoneInput $input) {
            return $input;
        };

        return $callback(PhoneInput::make('phone'));
    }

    public static function phoneTableColumn(?callable $callback = null): void
    {
        self::$phoneTableColumn = $callback;
    }

    public static function getPhoneTableColumn(): ?PhoneColumn
    {
        $callback = self::$phoneTableColumn ?: function (PhoneColumn $input) {
            return $input;
        };

        return $callback(PhoneColumn::make('phone'));
    }

    public static function form(Schema $schema): Schema
    {
        return FilamentPhoneInputUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FilamentPhoneInputUsersTable::configure($table);
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
            'index' => ListFilamentPhoneInputUsers::route('/'),
            'create' => CreateFilamentPhoneInputUser::route('/create'),
            'edit' => EditFilamentPhoneInputUser::route('/{record}/edit'),
        ];
    }
}
