<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource\Pages;

class FilamentPhoneInputUserResource extends Resource
{
    protected static ?string $model = FilamentPhoneInputUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static $phoneInputCallback = null;

    protected static ?string $slug = 'users';

    public static function phoneInput(callable $callback = null): void
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->autofocus()
                    ->placeholder('Enter a name...')
                    ->helperText('This is the name of the user.'),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->placeholder('Enter an email address...')
                    ->helperText('This is the email address of the user.'),

                static::getPhoneInput(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
