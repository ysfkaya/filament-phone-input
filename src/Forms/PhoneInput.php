<?php

namespace Ysfkaya\FilamentPhoneInput\Forms;

use Closure;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;
use Propaganistas\LaravelPhone\Rules\Phone as PhoneRule;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class PhoneInput extends Field
{
    use HasAffixes,
        HasExtraInputAttributes,
        HasPlaceholder;

    protected string $view = 'filament-phone-input::phone-input';

    protected string $displayNumberFormat = 'NATIONAL';

    protected string $inputNumberFormat = 'E164';

    protected string|false $focusNumberFormat = false;

    protected bool $allowDropdown = true;

    protected string $autoPlaceholder = 'aggressive';

    protected string $customContainer = '';

    protected ?string $dropdownContainer = null;

    protected array $excludeCountries = [];

    protected bool $formatOnDisplay = true;

    protected string $initialCountry = 'auto';

    protected array $localizedCountries = [];

    protected bool $nationalMode = true;

    protected array $onlyCountries = [];

    protected string $placeholderNumberType = 'MOBILE';

    protected array $preferredCountries = ['us', 'gb'];

    protected bool $separateDialCode = false;

    protected ?Closure $ipLookupCallback = null;

    public bool $canPerformIpLookup = true;

    public ?string $validatedCountry = null;

    public string|Closure|null $countryStatePath = null;

    public bool $countryStatePathIsAbsolute = false;

    public ?string $defaultCountry = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ipLookup(function () {
            return rescue(fn () => Http::get('https://ipinfo.io/json')->json('country'), app()->getLocale(), report: false);
        });

        $this->registerListeners([
            'phoneInput::ipLookup' => [
                function (PhoneInput $component, string $statePath) {
                    if ($statePath !== $component->getStatePath()) {
                        return;
                    }

                    if (! $component->canPerformIpLookup) {
                        return;
                    }

                    /** @var Page $livewire */
                    $livewire = $component->getLivewire();

                    $country = $component->performIpLookup();

                    if (! $country) {
                        return;
                    }

                    $livewire->dispatch('phoneInput::setCountry', [
                        'country' => $country,
                        'statePath' => $statePath,
                    ]);
                },
            ],
        ]);

        $this->afterStateHydrated(function (PhoneInput $component, $livewire, $state) {
            $country = null;

            if ($component->hasCountryStatePath()) {
                $country = data_get($livewire, $countryStatePath = $component->getCountryStatePath());

                data_set($livewire, $countryStatePath, $country);
            }

            if (! $state) {
                return;
            }

            $format = PhoneInputNumberType::from($component->getInputNumberFormat());

            $component->state($this->phoneFormat($state, $country, $format->toLibPhoneNumberFormat()));
        });

        $this->beforeStateDehydrated(function (PhoneInput $component, $state) {
            if (! $state) {
                return;
            }

            $format = PhoneInputNumberType::from($component->getInputNumberFormat());

            $country = $this->validatedCountry === 'AUTO' ? null : $this->validatedCountry;

            if ($component->hasCountryStatePath()) {
                $countryStatePath = $component->getCountryStatePath();

                $livewire = $component->getLivewire();

                $country = data_get($livewire, $countryStatePath);

                $format = PhoneInputNumberType::NATIONAL;
            }

            $component->state($this->phoneFormat($state, $country, $format->toLibPhoneNumberFormat()));
        });
    }

    /**
     * Default country code uses when parsing the phone number to avoid exceptions.
     *
     * @return $this
     */
    public function defaultCountry(string $value): static
    {
        $this->defaultCountry = $value;

        return $this;
    }

    protected function phoneFormat($state, $country, $format)
    {
        $country ??= $this->defaultCountry;

        $instance = phone(number: $state, country: $country);

        if ($instance->isValid()) {
            return $instance->format($format);
        }

        $lenientInstance = $instance->lenient();

        if ($lenientInstance->isValid()) {
            return $lenientInstance->format($format);
        }

        return $state;
    }

    public function dehydrateValidationRules(array &$rules): void
    {
        parent::dehydrateValidationRules($rules);

        if ($this->hasCountryStatePath()) {
            $countryStatePath = $this->getCountryStatePath();

            $rules[$countryStatePath] = ['nullable'];
        }
    }

    public function hasCountryStatePath(): bool
    {
        return $this->countryStatePath !== null;
    }

    public function countryStatePath(string|Closure $statePath, bool $isStatePathAbsolute = false): static
    {
        $this->countryStatePath = $statePath;
        $this->countryStatePathIsAbsolute = $isStatePathAbsolute;

        return $this;
    }

    public function getCountryStatePath()
    {
        return $this->generateRelativeStatePath($this->countryStatePath, $this->countryStatePathIsAbsolute);
    }

    public function validateFor(string|array $country = 'AUTO', string $type = null, bool $lenient = false)
    {
        $this->validatedCountry = $country;

        $rule = (new PhoneRule)->country($country)->type($type);

        if ($lenient) {
            $rule->lenient();
        }

        return $this->rules([
            $rule,
        ]);
    }

    public function disableIpLookUp(): static
    {
        $this->canPerformIpLookup = false;

        return $this;
    }

    public function ipLookup(Closure $callback): static
    {
        $this->ipLookupCallback = $callback;

        return $this;
    }

    public function performIpLookup()
    {
        return $this->evaluate($this->ipLookupCallback);
    }

    public function displayNumberFormat(PhoneInputNumberType $format): static
    {
        $this->displayNumberFormat = $format->value;

        return $this;
    }

    public function focusNumberFormat(PhoneInputNumberType|false $format): static
    {
        if ($format !== false) {
            $format = $format->value;
        }

        $this->focusNumberFormat = $format;

        return $this;
    }

    public function inputNumberFormat(PhoneInputNumberType $format): static
    {
        $this->inputNumberFormat = $format->value;

        return $this;
    }

    public function getInputNumberFormat(): string
    {
        return $this->inputNumberFormat;
    }

    public function disallowDropdown(): static
    {
        $this->allowDropdown = false;

        return $this;
    }

    public function autoPlaceholder(string $value): static
    {
        $this->autoPlaceholder = $value;

        return $this;
    }

    public function customContainer(string $value): static
    {
        $this->customContainer = $value;

        return $this;
    }

    public function dropdownContainer(?string $value): static
    {
        $this->dropdownContainer = $value;

        return $this;
    }

    public function excludeCountries(array $value): static
    {
        $this->excludeCountries = $value;

        return $this;
    }

    public function formatOnDisplay(bool $value): static
    {
        $this->formatOnDisplay = $value;

        return $this;
    }

    public function initialCountry(string $value): static
    {
        $this->initialCountry = $value;

        return $this;
    }

    public function localizedCountries(array $value): static
    {
        $this->localizedCountries = $value;

        return $this;
    }

    public function nationalMode(bool $value): static
    {
        $this->nationalMode = $value;

        return $this;
    }

    public function onlyCountries(array $value): static
    {
        $this->onlyCountries = $value;

        return $this;
    }

    public function placeholderNumberType(string $value): static
    {
        $this->placeholderNumberType = $value;

        return $this;
    }

    public function preferredCountries(array $value): static
    {
        $this->preferredCountries = $value;

        return $this;
    }

    public function separateDialCode(bool $value = true): static
    {
        $this->separateDialCode = $value;

        return $this;
    }

    public function isRtl()
    {
        $direction = __('filament::layout.direction') ?? 'ltr'; // @phpstan-ignore-line

        return $direction === 'rtl';
    }

    public function getJsonPhoneInputConfiguration(): string
    {
        return json_encode([
            'allowDropdown' => $this->allowDropdown,

            'autoPlaceholder' => $this->autoPlaceholder,

            'customContainer' => $this->customContainer,

            'dropdownContainer' => $this->dropdownContainer,

            'excludeCountries' => $this->excludeCountries,

            'formatOnDisplay' => $this->formatOnDisplay,

            'performIpLookup' => $this->canPerformIpLookup,

            'initialCountry' => $this->initialCountry,

            'localizedCountries' => $this->localizedCountries,

            'nationalMode' => $this->nationalMode,

            'onlyCountries' => $this->onlyCountries,

            'placeholderNumberType' => $this->placeholderNumberType,

            'preferredCountries' => $this->preferredCountries,

            'separateDialCode' => $this->separateDialCode,

            'displayNumberFormat' => $this->displayNumberFormat,

            'focusNumberFormat' => $this->focusNumberFormat,
        ]);
    }
}
