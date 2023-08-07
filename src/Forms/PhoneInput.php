<?php

namespace Ysfkaya\FilamentPhoneInput\Forms;

use Closure;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class PhoneInput extends Field
{
    use HasPlaceholder,
        HasAffixes,
        HasExtraInputAttributes;

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

    protected function setUp(): void
    {
        parent::setUp();

        $this->ipLookup(function () {
            return rescue(fn () => Http::get('https://ipinfo.io/json')->json('country'), report: false);
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
    }

    public function disableIpLookUp()
    {
        $this->canPerformIpLookup = false;

        return $this;
    }

    public function ipLookup(Closure $callback)
    {
        $this->ipLookupCallback = $callback;

        return $this;
    }

    public function performIpLookup()
    {
        return $this->evaluate($this->ipLookupCallback);
    }

    public function displayNumberFormat(PhoneInputNumberType $format): self
    {
        $this->displayNumberFormat = $format->value;

        return $this;
    }

    public function focusNumberFormat(PhoneInputNumberType|false $format): self
    {
        if ($format !== false) {
            $format = $format->value;
        }

        $this->focusNumberFormat = $format;

        return $this;
    }

    public function inputNumberFormat(PhoneInputNumberType $format): self
    {
        $this->inputNumberFormat = $format->value;

        return $this;
    }

    public function disallowDropdown()
    {
        $this->allowDropdown = false;

        return $this;
    }

    public function autoPlaceholder(string $value)
    {
        $this->autoPlaceholder = $value;

        return $this;
    }

    public function customContainer(string $value)
    {
        $this->customContainer = $value;

        return $this;
    }

    public function dropdownContainer(?string $value)
    {
        $this->dropdownContainer = $value;

        return $this;
    }

    public function excludeCountries(array $value)
    {
        $this->excludeCountries = $value;

        return $this;
    }

    public function formatOnDisplay(bool $value)
    {
        $this->formatOnDisplay = $value;

        return $this;
    }

    public function initialCountry(string $value)
    {
        $this->initialCountry = $value;

        return $this;
    }

    public function localizedCountries(array $value)
    {
        $this->localizedCountries = $value;

        return $this;
    }

    public function nationalMode(bool $value)
    {
        $this->nationalMode = $value;

        return $this;
    }

    public function onlyCountries(array $value)
    {
        $this->onlyCountries = $value;

        return $this;
    }

    public function placeholderNumberType(string $value)
    {
        $this->placeholderNumberType = $value;

        return $this;
    }

    public function preferredCountries(array $value)
    {
        $this->preferredCountries = $value;

        return $this;
    }

    public function separateDialCode(bool $value = true)
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

            'inputNumberFormat' => $this->inputNumberFormat,

            'focusNumberFormat' => $this->focusNumberFormat,
        ]);
    }
}
