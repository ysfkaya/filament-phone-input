<?php

namespace Ysfkaya\FilamentPhoneInput\Forms;

use Closure;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Contracts\HasAffixActions;
use Filament\Forms\Components\Field;
use Filament\Pages\Page;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Http;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use Propaganistas\LaravelPhone\Rules\Phone as PhoneRule;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class PhoneInput extends Field implements HasAffixActions
{
    use HasAffixes;
    use HasExtraInputAttributes;
    use HasPlaceholder;

    // @phpstan-ignore-next-line
    protected string $view = 'filament-phone-input::phone-input';

    protected string | Closure | PhoneInputNumberType $displayNumberFormat = PhoneInputNumberType::NATIONAL;

    protected string | Closure | PhoneInputNumberType $inputNumberFormat = PhoneInputNumberType::E164;

    protected string | false | Closure | PhoneInputNumberType $focusNumberFormat = false;

    protected string | Closure $placeholderNumberType = 'MOBILE';

    protected bool | Closure $allowDropdown = true;

    protected string | Closure $autoPlaceholder = 'polite';

    protected bool | Closure $countrySearch = true;

    protected bool | Closure $formatAsYouType = true;

    protected string | null | Closure $dropdownContainer = null;

    protected array | Closure $excludeCountries = [];

    protected bool | Closure $formatOnDisplay = true;

    protected string | Closure $initialCountry = 'auto';

    protected string | Closure $containerClass = '';

    protected array | Closure $i18n = [];

    protected bool | Closure $nationalMode = true;

    protected bool | Closure $fixDropdownWidth = true;

    protected array | Closure $onlyCountries = [];

    protected array | null | Closure $countryOrder = null;

    protected string | RawJs | Closure | null $customPlaceholder = null;

    protected bool | Closure $showFlags = true;

    protected bool | Closure $separateDialCode = false;

    protected bool | Closure $useFullscreenPopup = false;

    protected bool | Closure $isStrictMode = false;

    protected array | Closure $customOptions = [];

    protected string | Closure $cookieName = 'intlTelInputSelectedCountry';

    protected ?Closure $ipLookupCallback = null;

    protected bool | Closure $performIpLookup = true;

    protected string | Closure | null $countryStatePath = null;

    protected string | Closure | null $defaultCountry = null;

    protected bool $countryStatePathIsAbsolute = false;

    protected string | array $validatedCountry = [];

    protected string | Closure | null $locale = null;

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

                    if (! $component->canPerformIpLookup()) {
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

    protected function phoneFormat($state, $country, $format)
    {
        $country ??= $this->getDefaultCountry() ?? [];

        $instance = phone(number: $state, country: $country);

        if (is_int($format) && enum_exists(PhoneNumberFormat::class)) {
            $format = PhoneNumberFormat::tryFrom($format);
        }

        if (! $format) {
            return $state;
        }

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

    public function countryStatePath(string | Closure $statePath, bool $isStatePathAbsolute = false): static
    {
        $this->countryStatePath = $statePath;
        $this->countryStatePathIsAbsolute = $isStatePathAbsolute;

        return $this;
    }

    public function getCountryStatePath(): ?string
    {
        if (! $this->hasCountryStatePath()) {
            return null;
        }

        $path = $this->evaluate($this->countryStatePath);

        return $this->generateRelativeStatePath($path, $this->countryStatePathIsAbsolute);
    }

    public function validateFor(string | array $country = 'INTERNATIONAL', int | string | array | PhoneNumberType | null $type = null, bool $lenient = false)
    {
        $this->validatedCountry = $country;

        $rule = new PhoneRule;

        // @phpstan-ignore-next-line
        if (method_exists($rule, 'international') && ($country === 'AUTO' || $country === 'INTERNATIONAL')) {
            $rule->international();
        } else {
            $rule->country($country);
        }

        if ($lenient) {
            $rule->lenient();
        }

        if ($type) {
            $rule->type($type);
        }

        return $this->rule($rule);
    }

    /**
     * Default country code uses when parsing the phone number to avoid exceptions.
     *
     * @return $this
     */
    public function defaultCountry(string | Closure $value): static
    {
        $this->defaultCountry = $value;

        return $this;
    }

    public function getDefaultCountry(): ?string
    {
        return $this->evaluate($this->defaultCountry);
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

    public function disableLookup(): static
    {
        $this->performIpLookup = false;

        return $this;
    }

    public function enableIpLookup(bool | Closure $value = true): static
    {
        $this->performIpLookup = $value;

        return $this;
    }

    public function canPerformIpLookup(): bool
    {
        return $this->evaluate($this->performIpLookup);
    }

    public function inputNumberFormat(PhoneInputNumberType | Closure $format): static
    {
        $this->inputNumberFormat = $format->value;

        return $this;
    }

    public function getInputNumberFormat(): string
    {
        $value = $this->evaluate($this->inputNumberFormat);

        return $value instanceof PhoneInputNumberType ? $value->value : $value;
    }

    public function displayNumberFormat(PhoneInputNumberType | Closure $format): static
    {
        $this->displayNumberFormat = $format->value;

        return $this;
    }

    public function getDisplayNumberFormat(): string
    {
        $value = $this->evaluate($this->displayNumberFormat);

        return $value instanceof PhoneInputNumberType ? $value->value : $value;
    }

    public function focusNumberFormat(PhoneInputNumberType | false | Closure $format): static
    {
        if ($format !== false) {
            $format = $format->value;
        }

        $this->focusNumberFormat = $format;

        return $this;
    }

    public function getFocusNumberFormat(): string | false
    {
        $value = $this->evaluate($this->focusNumberFormat);

        return $value instanceof PhoneInputNumberType ? $value->value : $value;
    }

    public function disallowDropdown(): static
    {
        $this->allowDropdown = false;

        return $this;
    }

    public function allowDropdown(bool | Closure $value = true): static
    {
        $this->allowDropdown = $value;

        return $this;
    }

    public function isAllowDropdown(): bool
    {
        return $this->evaluate($this->allowDropdown);
    }

    public function autoPlaceholder(string | Closure $value): static
    {
        $this->autoPlaceholder = $value;

        return $this;
    }

    public function getAutoPlaceholder(): string
    {
        return $this->evaluate($this->autoPlaceholder);
    }

    public function containerClass(string | Closure $value): static
    {
        $this->containerClass = $value;

        return $this;
    }

    public function getContainerClass(): string
    {
        return $this->evaluate($this->containerClass);
    }

    public function countryOrder(array | Closure | null $value): static
    {
        $this->countryOrder = $value;

        return $this;
    }

    public function getCountryOrder(): ?array
    {
        return $this->evaluate($this->countryOrder);
    }

    public function countrySearch(bool | Closure $value = true): static
    {
        $this->countrySearch = $value;

        return $this;
    }

    public function isCountrySearch(): bool
    {
        return $this->evaluate($this->countrySearch);
    }

    public function customPlaceholder(string | RawJs | Closure | null $value): static
    {
        $this->customPlaceholder = $value;

        return $this;
    }

    public function getCustomPlaceholder(): ?RawJs
    {
        return $this->evaluate($this->customPlaceholder);
    }

    public function dropdownContainer(string | null | Closure $value): static
    {
        $this->dropdownContainer = $value;

        return $this;
    }

    public function getDropdownContainer(): ?string
    {
        return $this->evaluate($this->dropdownContainer);
    }

    public function excludeCountries(array | Closure $value): static
    {
        $this->excludeCountries = $value;

        return $this;
    }

    public function getExcludeCountries(): array
    {
        return $this->evaluate($this->excludeCountries);
    }

    public function fixDropdownWidth(bool | Closure $value = true): static
    {
        $this->fixDropdownWidth = $value;

        return $this;
    }

    public function isFixDropdownWidth(): bool
    {
        return $this->evaluate($this->fixDropdownWidth);
    }

    public function formatAsYouType(bool | Closure $value = true): static
    {
        $this->formatAsYouType = $value;

        return $this;
    }

    public function isFormatAsYouType(): bool
    {
        return $this->evaluate($this->formatAsYouType);
    }

    public function formatOnDisplay(bool | Closure $value = true): static
    {
        $this->formatOnDisplay = $value;

        return $this;
    }

    public function isFormatOnDisplay(): bool
    {
        return $this->evaluate($this->formatOnDisplay);
    }

    public function i18n(array | Closure $value): static
    {
        $this->i18n = $value;

        return $this;
    }

    public function getI18n(): array
    {
        return $this->evaluate($this->i18n);
    }

    public function initialCountry(string | Closure $value): static
    {
        $this->initialCountry = $value;

        return $this;
    }

    public function getInitialCountry(): string
    {
        return $this->evaluate($this->initialCountry);
    }

    public function nationalMode(bool | Closure $value = true): static
    {
        $this->nationalMode = $value;

        return $this;
    }

    public function isNationalMode(): bool
    {
        return $this->evaluate($this->nationalMode);
    }

    public function onlyCountries(array | Closure $value): static
    {
        $this->onlyCountries = $value;

        return $this;
    }

    public function getOnlyCountries(): array
    {
        return $this->evaluate($this->onlyCountries);
    }

    public function placeholderNumberType(string | Closure $value): static
    {
        $this->placeholderNumberType = $value;

        return $this;
    }

    public function getPlaceholderNumberType(): string
    {
        return $this->evaluate($this->placeholderNumberType);
    }

    public function showFlags(bool | Closure $value = true): static
    {
        $this->showFlags = $value;

        return $this;
    }

    public function isShowFlags(): bool
    {
        return $this->evaluate($this->showFlags);
    }

    public function separateDialCode(bool | Closure $value = true): static
    {
        $this->separateDialCode = $value;

        return $this;
    }

    public function isSeparateDialCode(): bool
    {
        return $this->evaluate($this->separateDialCode);
    }

    public function useFullscreenPopup(bool | Closure $value = true): static
    {
        $this->useFullscreenPopup = $value;

        return $this;
    }

    public function isUseFullscreenPopup(): bool
    {
        return $this->evaluate($this->useFullscreenPopup);
    }

    public function strictMode(bool | Closure $value = true): static
    {
        $this->isStrictMode = $value;

        return $this;
    }

    public function isStrictMode(): bool
    {
        return $this->evaluate($this->isStrictMode);
    }

    public function cookieName(string | Closure $value): static
    {
        $this->cookieName = $value;

        return $this;
    }

    public function getCookieName(): string
    {
        return $this->evaluate($this->cookieName);
    }

    public function locale(string | Closure $value): static
    {
        $this->locale = $value;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->evaluate($this->locale) ?? app()->getLocale();
    }

    public function customOptions(array | Closure $value): static
    {
        $this->customOptions = $value;

        return $this;
    }

    public function getCustomOptions(): array
    {
        return $this->evaluate($this->customOptions);
    }
}
