<?php

namespace Ysfkaya\FilamentPhoneInput\Tables;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;
use libphonenumber\PhoneNumberFormat;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class PhoneInputColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->displayFormat(PhoneInputNumberType::NATIONAL);
    }

    public function displayFormat(PhoneInputNumberType $format)
    {
        return $this->formatStateUsing(function ($state) use ($format) {
            $format = $format->toLibPhoneNumberFormat();

            if ($format === PhoneNumberFormat::RFC3966) {
                $formatted = phone($state, format: $format);
                $national = phone($state, format: PhoneNumberFormat::NATIONAL);

                $html = <<<HTML
                    <a href="$formatted">
                        $national
                    </a>
                HTML;

                return new HtmlString($html);
            }

            return phone($state, format: $format);
        })->when($format === PhoneInputNumberType::RFC3966, fn (PhoneInputColumn $column) => $column->disabledClick());
    }
}
