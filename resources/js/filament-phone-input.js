import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/js/utils";

export default function phoneInputFormComponent({
    getInputTelOptionsUsing,
    state,
    statePath,
    isLive,
    isLiveDebounced,
    isLiveOnBlur,
    liveDebounce,
    country = undefined,
}) {
    return {
        state,
        statePath,
        country,
        input: null,
        intlTelInput: null,
        initialized: false,

        options: {}, // intlTelInput options

        intlTelInputSelectedCountryCookie: "intlTelInputSelectedCountry",

        async init() {
            // Waits for until intlTelInput to be fully loaded
            // Loads the component after a certain time because it
            // causes problems with the elements added to the DOM later. e.g. Repeater
            await new Promise((resolve) => setTimeout(resolve, 150));

            this.options = getInputTelOptionsUsing(intlTelInput);

            this.applyGeoIpLookup();

            this.input = this.$refs.input;

            this.intlTelInput = intlTelInput(this.input, this.options);

            if (this.state) {
                const value = this.state?.valueOf();

                this.intlTelInput.setNumber(value);

                setTimeout(() => {
                    this.updateState();
                }, 1);
            }

            this.$nextTick(() => {
                this.initialized = true;
            });

            this.input.addEventListener("countrychange", () => {
                let countryData = this.intlTelInput.getSelectedCountryData();

                if (countryData.iso2) {
                    setCookie(
                        this.intlTelInputSelectedCountryCookie,
                        countryData.iso2?.toUpperCase()
                    );

                    this.updateState();

                    if (this.initialized) {
                        this.commitLiveState();
                    }
                }
            });

            this.input.addEventListener("change", (e) => {
                this.updateState();
            });

            this.input.addEventListener("input", (e) => {
                this.commitLiveState(() => {
                    this.updateState();
                });
            });

            this.input.addEventListener("blur", (e) => {
                this.updateState();

                if (isLiveOnBlur) {
                    this.commitState();
                }
            });

            this.input.addEventListener("focus", () => {
                const format = this.options.focusNumberFormat || false;

                if (format !== false) {
                    this.input.value = this.intlTelInput.getNumber(
                        window.intlTelInputUtils.numberFormat[format]
                    );
                }
            });

            this.$watch("state", (value) => {
                this.$nextTick(() => {
                    if (value !== null && value !== undefined) {
                        this.intlTelInput.setNumber(value);
                    } else {
                        this.intlTelInput.setNumber("");

                        this.updateCountryState(null);
                    }

                    if (value !== undefined) {
                        this.updateState();
                    } else {
                        this.updateCountryState(null);
                    }
                });
            });
        },

        async commitLiveState(cbx = null) {
            if (!isLiveOnBlur && (isLive || isLiveDebounced)) {
                await this.$nextTick();

                if (cbx) {
                    cbx();
                }

                const value = this.intlTelInput.getNumber(
                    window.intlTelInputUtils.numberFormat["E164"]
                );

                const selectedCountry = this.intlTelInput
                    .getSelectedCountryData()
                    .iso2?.toUpperCase();

                if (
                    this.state !== value ||
                    (this.country && this.country !== selectedCountry)
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

        updateState() {
            const displayNumberFormat = this.options.displayNumberFormat || "E164";
            const numberFormat = this.options.inputNumberFormat || "E164";

            this.state = this.intlTelInput.getNumber(
                window.intlTelInputUtils.numberFormat[numberFormat]
            );

            this.input.value = this.intlTelInput.getNumber(
                window.intlTelInputUtils.numberFormat[displayNumberFormat]
            );

            this.updateCountryState();
        },

        updateCountryState(value = undefined) {
            if (country !== undefined) {
                if (value !== undefined) {
                    this.country = value;

                    return;
                }

                const countryData = this.intlTelInput.getSelectedCountryData();

                this.country = countryData.iso2?.toUpperCase();
            }
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
                let country = getCookie(this.intlTelInputSelectedCountryCookie);

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
                                this.intlTelInputSelectedCountryCookie,
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
