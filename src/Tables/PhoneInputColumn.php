<?php

namespace Ysfkaya\FilamentPhoneInput\Tables;

use Closure;
use Filament\Tables\Columns\TextColumn;

class PhoneInputColumn extends TextColumn
{
    protected string|Closure|null $displayFormat = null;

    public function displayFormat(string|Closure $format)
    {
        $this->displayFormat = $format;

        return $this;
    }
}
