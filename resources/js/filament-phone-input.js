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
        ({options, state}) => {
            return {
                state,

                instance: null,

                options, // intlTelInput options

                init() {

                    this.applyGeoIpLookup()

                    this.instance = intlTelInput(this.$el, this.options)

                    if (this.state) {
                        this.instance.setNumber(this.state?.valueOf())
                    }

                    this.listenCountryChange()

                    this.$el.addEventListener("change", this.updateState.bind(this));

                    if(this.options.focusNumberFormat) {
                        this.$el.addEventListener("focus", () => {
                            this.$el.value = this.instance.getNumber(
                                intlTelInputUtils.numberFormat[this.options.focusNumberFormat]
                            )
                        })
                    }

                    this.$watch("state", (value) => {
                        this.$nextTick(() => {
                            if(this.state !== this.getInputFormattedValue()) {
                                this.instance.setNumber(value)
                            }
                        });
                    });
                },

                listenCountryChange() {
                    this.$el.addEventListener("countrychange", () => {
                        let countryData =
                            this.instance.getSelectedCountryData()

                        if (countryData.iso2) {
                            setCookie(
                                this.IntlTelInputSelectedCountryCookie,
                                countryData.iso2?.toUpperCase()
                            );

                            this.updateState()
                        }
                    });
                },

                getInputFormattedValue() {
                    return this.instance.getNumber(
                        intlTelInputUtils.numberFormat[this.options.inputNumberFormat]
                    )
                },

                updateState() {
                    this.$el.value = this.instance.getNumber(
                        intlTelInputUtils.numberFormat[this.options.displayNumberFormat]
                    )

                    if(this.state !== this.getInputFormattedValue()) {
                        this.state = this.getInputFormattedValue()
                    }
                },

                applyGeoIpLookup() {
                    if(!this.options.geoIPLookup) {
                        this.options.initialCountry = this.options.initialCountry === 'auto' ? this.options.preferredCountries[0]?.toUpperCase() : this.options.initialCountry.toUpperCase()
                        this.options.geoIPLookup = null
                    }
                    this.options.geoIPLookup =
                        function (success, failure) {
                            let country = getCookie(this.IntlTelInputSelectedCountryCookie)
                            if (country) {
                                success(country)
                            } else {
                                fetch("https://ipinfo.io/json")
                                    .then((res) => res.json())
                                    .then((data) => data)
                                    .then((data) => {
                                        let country = data.country?.toUpperCase()
                                        success(country)
                                        setCookie(this.IntlTelInputSelectedCountryCookie, country)
                                    })
                                    .catch((error) => success(this.options.preferredCountries[0]?.toUpperCase()))
                            }

                        }
                }
            };
        }
    );
})
;
