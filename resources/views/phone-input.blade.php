@php
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
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
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
    >
        <div class="inline-flex w-full" wire:ignore dusk="phone-input.{{ $id }}">
            <span
                class="w-full"
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

