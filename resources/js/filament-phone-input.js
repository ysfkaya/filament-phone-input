import intlTelInput from "intl-tel-input/intlTelInputWithUtils";
import * as locales from "intl-tel-input/i18n";

export default function phoneInputFormComponent({
    options,
    locale,
    state,
    countryState = undefined,
    intlTelInputSelectedCountryCookieName,
    statePath,
    isLive,
    isLiveDebounced,
    isLiveOnBlur,
    liveDebounce,
}) {
    return {
        state,
        countryState,
        statePath,
        input: null,
        intlTelInput: null,
        intlTelInputSelectedCountryCookieName,

        options: {}, // intlTelInput options

        async init() {
            // Waits for until intlTelInput to be fully loaded
            // Loads the component after a certain time because it
            // causes problems with the elements added to the DOM later. e.g. Repeater
            await new Promise((resolve) => setTimeout(resolve, 150));

            this.initOptions();

            this.applyGeoIpLookup();

            this.input = this.$refs.input;

            this.intlTelInput = intlTelInput(this.input, this.options);

            this.initState(this.state);

            this.input.addEventListener("countrychange", () => {
                let countryData = this.intlTelInput.getSelectedCountryData();

                if (countryData.iso2) {
                    setCookie(
                        this.intlTelInputSelectedCountryCookieName,
                        countryData.iso2?.toUpperCase()
                    );

                    this.formatState();

                    this.$nextTick(() => this.commitLiveState());
                }
            });

            this.input.addEventListener("input", (e) => {
                this.formatState();
                this.commitLiveState();
            });

            this.input.addEventListener("blur", (e) => {
                this.formatState();

                if (isLiveOnBlur) {
                    this.commitState();
                }
            });

            this.input.addEventListener("focus", () => {
                const format = this.options.focusNumberFormat || false;

                if (format !== false) {
                    this.input.value = this.intlTelInput.getNumber(
                        intlTelInput.utils.numberFormat[format]
                    );
                }
            });

            this.$watch("state", (value) => {
                this.initState(value);
            });

            document.addEventListener("phoneInput:isDisabled", (event) => {
                if (event.detail.statePath !== this.statePath) {
                    return;
                }

                this.$refs.input.disabled = event.detail.isDisabled;

                const itiContainer = this.$refs.input.closest(".iti");

                itiContainer.querySelector(
                    "button.iti__selected-country"
                ).disabled = event.detail.isDisabled;

                if (event.detail.isDisabled) {
                    itiContainer.querySelector(
                        "button.iti__selected-country"
                    ).tabIndex = -1;
                } else {
                    itiContainer
                        .querySelector("button.iti__selected-country")
                        .removeAttribute("tabindex");
                }
            });
        },

        initOptions() {
            this.options = {
                ...options,
                i18n: {
                    ...(locales[locale] ?? {}),
                    ...options.i18n,
                },
            };
        },

        async commitLiveState(cbx = null) {
            if (!isLiveOnBlur && (isLive || isLiveDebounced)) {
                await this.$nextTick();

                if (cbx) {
                    cbx();
                }

                const value = this.intlTelInput.getNumber(
                    intlTelInput.utils.numberFormat.E164
                );

                const selectedCountry = this.intlTelInput
                    .getSelectedCountryData()
                    .iso2?.toUpperCase();

                if (
                    this.state !== value ||
                    (this.countryState && this.countryState !== selectedCountry)
                ) {
                    return;
                }

                if (isLiveDebounced) {
                    Alpine.debounce(() => {
                        this.commitState();
                    }, liveDebounce)();
                } else if (isLive) {
                    this.commitState();
                }
            }
        },

        initState(value) {
            if (value) {
                value = value?.valueOf();

                this.intlTelInput.setNumber(value);

                this.$nextTick(() => {
                    this.formatState();
                });

                this.updateCountryState();
            } else if (value === null) {
                this.input.value = "";

                this.state = null;
            }
        },

        formatState() {
            const displayNumberFormat =
                this.options.displayNumberFormat || "E164";
            const numberFormat = this.options.inputNumberFormat || "E164";

            this.state =
                this.intlTelInput.getNumber(
                    intlTelInput.utils.numberFormat[numberFormat]
                ) || null;

            if (this.options.formatAsYouType !== true) {
                this.input.value =
                    this.intlTelInput.getNumber(
                        intlTelInput.utils.numberFormat[displayNumberFormat]
                    ) || null;
            }
        },

        updateCountryState(value = undefined) {
            if (countryState === undefined) {
                return;
            }

            if (value !== undefined) {
                this.countryState = value;

                return;
            }

            const countryData = this.intlTelInput.getSelectedCountryData();

            this.countryState = countryData.iso2?.toUpperCase();

            window.duskCountryValue = this.countryState;
        },

        commitState() {
            if (
                JSON.stringify(this.$wire.__instance.canonical) ===
                JSON.stringify(this.$wire.__instance.ephemeral)
            ) {
                return;
            }

            this.$wire.$commit();
        },

        applyGeoIpLookup() {
            if (!this.options.performIpLookup) {
                return;
            }

            this.options.geoIpLookup = async function (success, failure) {
                let country = getCookie(
                    this.intlTelInputSelectedCountryCookieName
                );

                if (country) {
                    success(country);
                } else {
                    try {
                        await this.$wire.call(
                            "dispatchFormEvent",
                            "phoneInput::ipLookup",
                            this.statePath
                        );

                        const dispatches =
                            this.$wire.__instance.effects?.dispatches;

                        if (!dispatches) {
                            return;
                        }

                        const setCountryDispatch = dispatches.find(
                            (dispatch) =>
                                dispatch.name === "phoneInput::setCountry"
                        );

                        if (!setCountryDispatch) {
                            return;
                        }

                        const params = setCountryDispatch.params[0];

                        const { statePath, country } = params;

                        if (statePath !== this.statePath) {
                            return;
                        }

                        window.phoneInputGeoIpLookup = true;

                        this.$nextTick(() => {
                            success(country);
                            setCookie(
                                this.intlTelInputSelectedCountryCookieName,
                                country
                            );
                        });
                    } catch (error) {
                        failure(error);
                    }
                }
            }.bind(this);
        },
    };
}

function setCookie(
    cookieName,
    cookieValue,
    expiryDays = null,
    path = null,
    domain = null
) {
    let cookieString = `${cookieName}=${cookieValue};`;
    if (expiryDays) {
        const d = new Date();
        d.setTime(d.getTime() + expiryDays * 24 * 60 * 60 * 1000);
        cookieString += `expires=${d.toUTCString()};`;
    }
    if (path) {
        cookieString += `path=${path};`;
    }
    if (domain) {
        cookieString += `domain=${domain};`;
    }
    document.cookie = cookieString;
}

function getCookie(cookieName) {
    let name = cookieName + "=";
    let ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
