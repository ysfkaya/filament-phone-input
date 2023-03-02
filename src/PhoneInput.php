<?php

namespace Ysfkaya\FilamentPhoneInput;

use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;

class PhoneInput extends Field
{
    use HasPlaceholder,
        HasAffixes,
        HasExtraInputAttributes;

    protected string $view = 'filament-phone-input::phone-input';

    protected string $displayNumberFormat = 'NATIONAL';

    protected string $inputNumberFormat = 'E164';

    protected ?string $focusNumberFormat = null;

    protected bool $allowDropdown = true;

    protected string $autoPlaceholder = 'aggressive';

    protected string $customContainer = '';

    protected ?string $customPlaceholder = null;

    protected array $excludeCountries = [];

    protected bool $formatOnDisplay = true;

    protected bool $geoIpLookup = true;

    protected string $initialCountry = 'auto';

    protected array $localizedCountries = [];

    protected bool $nationalMode = true;

    protected array $onlyCountries = [];

    protected string $placeholderNumberType = 'MOBILE';

    protected array $preferredCountries = ['us', 'gb'];

    protected bool $separateDialCode = false;

    /**
     * Default: 'NATIONAL'
     * formats frontend 
     */
    public function displayNumberFormat(PhoneInputNumberFormat $format): self
    {
        $this->displayNumberFormat = $format->value;

        return $this;
    }

    /** apply different format when input is focused */
    public function focusNumberFormat(PhoneInputNumberFormat $format): self
    {

        $this->focusNumberFormat = $format->value;

        return $this;
    }


    /** formatted value returned to backend */
    public function inputNumberFormat(PhoneInputNumberFormat $format): self
    {
        $this->inputNumberFormat = $format->value;

        return $this;
    }

    /**
     * Flag dropdown disabled. The selected flag moves to the right as a marker of state.
     */
    public function disallowDropdown(): static
    {
        $this->allowDropdown = false;

        return $this;
    }

    /**
     * Default: 'aggressive' <br>
     * Placeholder autoformatting method. <br>
     * @see PlaceholderMethod enum, for explanation.
     * @see placeholderNumberType() for formatting options.
     */
    public function placeholderMethod(PlaceholderMethod $method): static
    {
        $this->autoPlaceholder = $method->value;

        return $this;
    }

    /**
     *  Default: "MOBILE"
     *  PhoneInputNumberType to format the placeholder number.
     */
    public function placeholderFormat(PhoneInputNumberType $type): static
    {
        $this->placeholderNumberType = $type->value;

        return $this;
    }

    /** Additional classes to add to the generated parent div */
    public function customContainerClasses(string $value): static
    {
        $this->customContainer = $value;

        return $this;
    }


    public function excludeCountries(array $value): static
    {
        $this->excludeCountries = $value;

        return $this;
    }

    /**
     * Default: true <br>
     * Format the input value (according to the nationalMode option) <br>
     * during init and when value changed from backend.
     */
    public function formatOnDisplay(bool $value): static
    {
        $this->formatOnDisplay = $value;

        return $this;
    }

    /**
     * Required if initialCountry = "auto". <br>
     * If false, fallback is <br>
     * initialCountry ?? preferredCountries[0]
     */
    public function geoIpLookup(bool $value = true): static
    {
        $this->geoIpLookup = $value;

        return $this;
    }


    /**  $value must eq 'auto' or a valid country code, like 'us' */
    public function initialCountry(string $value): static
    {
        $this->initialCountry = $value;

        return $this;
    }

    /** Translate the countries by its given iso code <br>
     * i.e. [ 'se' => 'Sverige' ]
     */
    public function localizedCountries(array $value): static
    {
        $this->localizedCountries = $value;

        return $this;
    }

    /**
     * Default: true <br>
     * Allow entering national numbers without international dial codes. <br>
     * while still returning a full international number, to backend
     */
    public function nationalMode(bool $value): static
    {
        $this->nationalMode = $value;

        return $this;
    }

    /** displayed dropdown countries */
    public function onlyCountries(array $value): static
    {
        $this->onlyCountries = $value;

        return $this;
    }


    /** fallback if geoIPLookup fails, @see geoIpLookup()   */
    public function preferredCountries(array $value): static
    {
        $this->preferredCountries = $value;

        return $this;
    }

    /** Display the country dial code next to the selected flag */
    public function separateDialCode(bool $value): static
    {
        $this->separateDialCode = $value;

        return $this;
    }

    public function isRtl(): bool
    {
        $direction = __('filament::layout.direction') ?? 'ltr';

        return $direction === 'rtl';
    }

    public function getJsonPhoneInputConfiguration(): array
    {
        return [
            'allowDropdown' => $this->allowDropdown,

            'autoPlaceholder' => $this->autoPlaceholder,

            'customContainer' => $this->customContainer,

            'excludeCountries' => $this->excludeCountries,

            'formatOnDisplay' => $this->formatOnDisplay,

            'geoIpLookup' => $this->geoIpLookup,

            'initialCountry' => $this->initialCountry,

            'localizedCountries' => $this->localizedCountries,

            'nationalMode' => $this->nationalMode,

            'onlyCountries' => $this->onlyCountries,

            'placeholderNumberType' => $this->placeholderNumberType,

            'preferredCountries' => $this->preferredCountries,

            'separateDialCode' => $this->separateDialCode,

            'displayNumberFormat' => $this->displayNumberFormat,

            'inputNumberFormat' => $this->inputNumberFormat,

            'focusNumberFormat' => $this->focusNumberFormat,

            'utilsScript' => '/filament/assets/intl-tel-input-utils.js',
        ];
    }
}
