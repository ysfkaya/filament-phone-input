import intlTelInput from "intl-tel-input";

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

function removeCookie(cookieName, path = null, domain = null) {
    let cookieString = `${cookieName}=;`;
    const d = new Date();
    d.setTime(d.getTime() - 30 * 24 * 60 * 60 * 1000);
    cookieString += `expires=${d.toUTCString()};`;
    if (path) {
        cookieString += `path=${path};`;
    }
    if (domain) {
        cookieString += `domain=${domain};`;
    }
    document.cookie = cookieString;
}

document.addEventListener("alpine:init", () => {
    Alpine.data(
        "phoneInputFormComponent",
        ({ getInputTelOptionsUsing, state, inputID }) => {
            return {
                state,

                inputID,

                instance: null,

                options: {}, // intlTelInput options

                intlTelInputSelectedCountryCookie: "intlTelInputSelectedCountry",

                init() {
                    this.options = getInputTelOptionsUsing(intlTelInput);

                    this.applyGeoIpLookup();
                    this.applyCustomPlaceholder();
                    this.applyUtilsScript();

                    this.instance = intlTelInput(this.$el, this.options);

                    if (this.state) {
                        const value = this.state?.valueOf();

                        this.instance.setNumber(value);

                        setTimeout(() => {
                            this.updateState();
                        }, 1);
                    }

                    this.listenCountryChange();

                    this.$el.addEventListener(
                        "change",
                        this.updateState.bind(this)
                    );

                    this.$el.addEventListener(
                        "blur",
                        this.updateState.bind(this)
                    );

                    this.$el.addEventListener("focus", () => {
                        const format = this.options.focusNumberFormat || false;

                        if (format !== false) {
                            this.$el.value = this.instance.getNumber(
                                window.intlTelInputUtils.numberFormat[format]
                            );
                        }
                    });

                    this.$watch("state", (value) => {
                        this.$nextTick(() => {
                            if (value !== null) {
                                this.instance.setNumber(value);
                            }else{
                                this.instance.setNumber('');
                            }

                            this.updateState();
                        });
                    });
                },

                listenCountryChange() {
                    this.$el.addEventListener("countrychange", () => {
                        let countryData =
                            this.instance.getSelectedCountryData();

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
                    const inputNumberFormat =
                        this.options.inputNumberFormat || "E164";

                    this.state = this.instance.getNumber(
                        window.intlTelInputUtils.numberFormat[inputNumberFormat]
                    );

                    this.$el.value = this.instance.getNumber(
                        window.intlTelInputUtils.numberFormat[
                            displayNumberFormat
                        ]
                    );
                },

                applyGeoIpLookup() {
                    // geoIpLookup option
                    if (this.options.geoIpLookup == null) {
                        // unset it if null
                        delete this.options.geoIpLookup;
                    } else if (this.options.geoIpLookup === "ipinfo") {
                        this.options.geoIpLookup = function (success, failure) {
                            let country = getCookie(
                                this.intlTelInputSelectedCountryCookie
                            );

                            if (country) {
                                success(country);
                            } else {
                                fetch("https://ipinfo.io/json")
                                    .then((res) => res.json())
                                    .then((data) => data)
                                    .then((data) => {
                                        let country =
                                            data.country?.toUpperCase();
                                        success(country);
                                        setCookie(
                                            this
                                                .intlTelInputSelectedCountryCookie,
                                            country
                                        );
                                    })
                                    .catch((error) => success("US"));
                            }
                        }.bind(this);
                    } else if (
                        typeof window[this.options.geoIpLookup] === "function"
                    ) {
                        // user custom function
                        this.options.geoIpLookup =
                            window[this.options.geoIpLookup];
                    } else {
                        if (typeof this.options.geoIpLookup !== "function") {
                            throw new TypeError(
                                `Phone-Input: Undefined function '${this.options.geoIpLookup}' specified in tel-input.options.geoIpLookup.`
                            );
                        }
                        delete this.options.geoIpLookup; // unset if undefined function
                    }
                },

                applyCustomPlaceholder() {
                    if (
                        this.options.customPlaceholder &&
                        typeof window[this.options.customPlaceholder] ===
                            "function"
                    ) {
                        // user custom function
                        this.options.customPlaceholder =
                            window[this.options.customPlaceholder];
                    }
                },

                applyUtilsScript() {
                    // utilsScript option
                    if (this.options.utilsScript) {
                        // Fix utilsScript relative path bug
                        this.options.utilsScript =
                            this.options.utilsScript.charAt(0) == "/"
                                ? this.options.utilsScript
                                : "/" + this.options.utilsScript;
                    }
                },
            };
        }
    );
});
