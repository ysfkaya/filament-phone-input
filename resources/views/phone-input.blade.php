@php
    use Filament\Support\Facades\FilamentView;
    use Illuminate\Support\Js;

    $hasInlineLabel = $hasInlineLabel();
    $id = $getId();
    $isConcealed = $isConcealed();
    $isDisabled = $isDisabled();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
    $key = $getKey();

    $isLive = $isLive();
    $isLiveOnBlur = $isLiveOnBlur();
    $isLiveDebounced = $isLiveDebounced();
    $liveDebounce = $getLiveDebounce();

    $cssUrl = \Filament\Support\Facades\FilamentAsset::getStyleHref('filament-phone-input', package: 'ysfkaya/filament-phone-input');

    $compiledCssUrl = Js::from($cssUrl);
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :inline-label-vertical-alignment="\Filament\Support\Enums\VerticalAlignment::Center"
>
    <x-slot
        name="label"
        @class([
            'sm:pt-1.5' => $hasInlineLabel,
        ])
    >
        {{ $getLabel() }}
    </x-slot>

    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :prefix-icon-color="$getPrefixIconColor()"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :suffix-icon-color="$getSuffixIconColor()"
        :valid="! $errors->has($statePath)"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class([
                    'fi-fo-phone-input',
                ])
        "
        x-data="{
            isDisabled: {{ $isDisabled ? 'true' : 'false' }},
            init(){
                $nextTick(() => {
                    $dispatch('phoneInput:isDisabled', { key: '{{ $key }}', isDisabled: this.isDisabled });
                });
            }
        }"
        x-load-css="[{{ $compiledCssUrl }}]"
    >
        <div
            dusk="phone-input.{{ $id }}"
            class="inline-flex w-full"
            wire:ignore
        >
            <div
                class="w-full"
                @if (FilamentView::hasSpaMode())
                    {{-- format-ignore-start --}}x-load="visible || event (ax-modal-opened)" {{-- format-ignore-end --}}
                @else
                    x-load
                @endif
                x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-phone-input', package: 'ysfkaya/filament-phone-input') }}"
                x-data="phoneInputFormComponent({
                    options: {
                        allowDropdown: @js($isAllowDropdown()),
                        autoPlaceholder: @js($getAutoPlaceholder()),
                        containerClass: @js($getContainerClass()),
                        countryOrder: @js($getCountryOrder()),
                        countrySearch: @js($isCountrySearch()),
                        customPlaceholder: @js($getCustomPlaceholder()),
                        dropdownContainer: @js($getDropdownContainer()),
                        excludeCountries: @js($getExcludeCountries()),
                        fixDropdownWidth: @js($isFixDropdownWidth()),
                        formatAsYouType: @js($isFormatAsYouType()),
                        formatOnDisplay: @js($isFormatOnDisplay()),
                        performIpLookup: @js($canPerformIpLookup()),
                        i18n: @js($getI18n()),
                        initialCountry: @js($getInitialCountry()),
                        nationalMode: @js($isNationalMode()),
                        onlyCountries: @js($getOnlyCountries()),
                        placeholderNumberType: @js($getPlaceholderNumberType()),
                        showFlags: @js($isShowFlags()),
                        separateDialCode: @js($isSeparateDialCode()),
                        strictMode: @js($isStrictMode()),
                        useFullscreenPopup: @js($isUseFullscreenPopup()),
                        displayNumberFormat: @js($getDisplayNumberFormat()),
                        inputNumberFormat: @js($getInputNumberFormat()),
                        focusNumberFormat: @js($getFocusNumberFormat()),
                        ...@js($getCustomOptions()),
                    },
                    locale: @js($getLocale()),
                    intlTelInputSelectedCountryCookieName: @js($getCookieName()),
                    state: $wire.$entangle('{{ $statePath }}'),
                    statePath: @js($statePath),
                    key: @js($key),
                    isLive: @js($isLive),
                    isLiveDebounced: @js($isLiveDebounced),
                    isLiveOnBlur: @js($isLiveOnBlur),
                    liveDebounce: @js($liveDebounce),
                    @if ($hasCountryStatePath() && $countryStatePath = $getCountryStatePath())
                        countryState: $wire.$entangle('{{ $countryStatePath }}'),
                    @endif
                })"
            >
                <x-filament::input
                    x-ref="input"
                    :attributes="
                        \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                            ->merge([
                                'id' => $id,
                                'autofocus' => $isAutofocused(),
                                'disabled' => $isDisabled,
                                'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                                'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                                'placeholder' => $getPlaceholder(),
                                'required' => $isRequired() && (! $isConcealed),
                                'type' => 'tel',
                            ], escape: false)
                    "
                />
            </div>
        </div>
    </x-filament::input.wrapper>
</x-dynamic-component>

