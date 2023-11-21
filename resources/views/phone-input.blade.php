@php
    use Filament\Support\Facades\FilamentView;
    
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

    $cssUrl = \Filament\Support\Facades\FilamentAsset::getStyleHref('filament-phone-input', package: 'ysfkaya/filament-phone-input');

    $compiledCssUrl = Js::from($cssUrl);
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :valid="! $errors->has($statePath)"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class([
                    'fi-fo-phone-input',
                    'rtl' => $isRtl(),
                ])
        "
        x-data="{}"
        x-load-css="[{{ $compiledCssUrl }}]"
    >
        <div
            wire:ignore
            dusk="phone-input.{{ $id }}"
            class="inline-flex w-full"
        >
            <span
                class="w-full"
                x-ignore
                @if (FilamentView::hasSpaMode())
                    ax-load="visible"
                @else
                    ax-load
                @endif
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-phone-input', package: 'ysfkaya/filament-phone-input') }}"
                x-data="phoneInputFormComponent({
                    getInputTelOptionsUsing: (intlTelInput) => ({{ $getJsonPhoneInputConfiguration() }}),
                    state: $wire.{{ $applyStateBindingModifiers("entangle('{$statePath}')") }},
                    statePath: @js($statePath),
                    @if ($hasCountryStatePath() && $countryStatePath = $getCountryStatePath())
                        country: $wire.{{ $applyStateBindingModifiers("entangle('{$countryStatePath}')") }},
                    @endif
                })"
            >
                <x-filament::input
                    x-ref="input"
                    :attributes="
                        \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                            ->merge([
                                'autofocus' => $isAutofocused(),
                                'disabled' => $isDisabled,
                                'id' => $id,
                                'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                                'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                                'placeholder' => $getPlaceholder(),
                                'required' => $isRequired() && (! $isConcealed),
                                'type' => 'tel',
                                'x-model' . ($isLiveDebounced() ? '.debounce.' . $getLiveDebounce() : null) => 'state',
                            ], escape: false)
                    "
                />
            </span>
        </div>
    </x-filament::input.wrapper>
</x-dynamic-component>

