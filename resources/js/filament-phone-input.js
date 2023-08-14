import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/js/utils";

export default function phoneInputFormComponent({
    getInputTelOptionsUsing,
    state,
    statePath,
    country = undefined,
}) {
    return {
        state,
        statePath,
        country,
        input: null,
        intlTelInput: null,

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

            this.listenCountryChange();

            this.input.addEventListener("change", this.updateState.bind(this));

            this.input.addEventListener("blur", this.updateState.bind(this));

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

        listenCountryChange() {
            this.input.addEventListener("countrychange", () => {
                let countryData = this.intlTelInput.getSelectedCountryData();

                if (countryData.iso2) {
                    setCookie(
                        this.intlTelInputSelectedCountryCookie,
                        countryData.iso2?.toUpperCase()
                    );

                    this.updateState();
                }
            });
        },

        updateState() {
            const displayNumberFormat =
                this.options.displayNumberFormat || "E164";
            const inputNumberFormat = "E164";

            this.state = this.intlTelInput.getNumber(
                window.intlTelInputUtils.numberFormat[inputNumberFormat]
            );

            this.input.value = this.intlTelInput.getNumber(
                window.intlTelInputUtils.numberFormat[displayNumberFormat]
            );

            this.updateCountryState(!this.state ? null : undefined);
        },

        updateCountryState(value = undefined) {
            if (this.country !== undefined) {
                if (value !== undefined) {
                    this.country = value;

                    return;
                }

                const countryData = this.intlTelInput.getSelectedCountryData();

                this.country = countryData.iso2?.toUpperCase();
            }
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
