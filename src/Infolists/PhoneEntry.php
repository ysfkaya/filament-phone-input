<?php

namespace Ysfkaya\FilamentPhoneInput\Infolists;

use Closure;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;
use libphonenumber\PhoneNumberFormat;
use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class PhoneEntry extends TextEntry
{
    protected string | Closure | null $countryColumn = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->displayFormat(PhoneInputNumberType::NATIONAL);
    }

    public function countryColumn(string | Closure $column): static
    {
        $this->countryColumn = $column;

        return $this;
    }

    public function getCountryColumn()
    {
        return $this->evaluate($this->countryColumn);
    }

    public function displayFormat(PhoneInputNumberType $format)
    {
        return $this->formatStateUsing(function ($state, $record) use ($format) {
            try {
                $countryColumn = $this->getCountryColumn();

                $country = [];

                if ($countryColumn) {
                    $country = $record->getAttributeValue($countryColumn);
                }

                $format = $format->toLibPhoneNumberFormat();

                $formatted = phone(
                    number: $state,
                    country: $country,
                    format: $format
                );

                if ($format === (enum_exists(PhoneNumberFormat::class) ? PhoneNumberFormat::RFC3966->value : PhoneNumberFormat::RFC3966)) {
                    $national = phone(
                        number: $state,
                        country: $country,
                        format: PhoneNumberFormat::NATIONAL
                    );

                    $html = <<<HTML
                        <a href="$formatted">
                            $national
                        </a>
                    HTML;

                    return new HtmlString($html);
                }

                return phone(
                    number: $state,
                    country: $country,
                    format: $format
                );
            } catch (NumberParseException $e) {
                return $state;
            }
        });
    }
}
