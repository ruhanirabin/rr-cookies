(function($) {
    'use strict';

    const RRCookies = {
        init: function() {
            this.params = window.rrCookiesParams || {};
            this.banner = $('#rr-cookies-banner');
            this.preferencesModal = $('#rr-cookies-preferences');
            
            this.setupBanner();
            this.bindEvents();
        },

        setupBanner: function() {
            const settings = this.params.settings;
            
            // Apply theme
            this.banner.attr('data-theme', settings.theme);
            this.banner.attr('data-position', settings.position);
            
            // Apply custom colors
            document.documentElement.style.setProperty('--rr-cookies-banner-bg', settings.colors.banner);
            document.documentElement.style.setProperty('--rr-cookies-text-color', settings.colors.text);
            document.documentElement.style.setProperty('--rr-cookies-button-bg', settings.colors.button);
            document.documentElement.style.setProperty('--rr-cookies-button-text', settings.colors.buttonText);

            // Set text content
            this.banner.find('.rr-cookies-banner-text p').text(this.params.texts.mainText);
            this.banner.find('.rr-cookies-accept-button').text(this.params.texts.acceptAll);
            this.banner.find('.rr-cookies-preferences-button').text(this.params.texts.preferences);

            // Show banner with animation
            setTimeout(() => {
                this.banner.addClass('show');
            }, 100);
        },

        bindEvents: function() {
            const self = this;

            // Accept all cookies
            this.banner.on('click', '.rr-cookies-accept-button', function() {
                self.acceptAll();
            });

            // Open preferences
            this.banner.on('click', '.rr-cookies-preferences-button', function() {
                self.showPreferences();
            });

            // Close preferences
            this.preferencesModal.on('click', '.rr-cookies-preferences-close', function() {
                self.hidePreferences();
            });

            // Save preferences
            this.preferencesModal.on('click', '.rr-cookies-save-preferences', function() {
                self.savePreferences();
            });

            // Close modal on outside click
            $(document).on('click', function(e) {
                if ($(e.target).is('.rr-cookies-preferences')) {
                    self.hidePreferences();
                }
            });
        },

        acceptAll: function() {
            this.setPreferences({
                necessary: true,
                analytics: true,
                marketing: true
            });
        },

        showPreferences: function() {
            this.preferencesModal.addClass('show');
        },

        hidePreferences: function() {
            this.preferencesModal.removeClass('show');
        },

        savePreferences: function() {
            const preferences = {
                necessary: true, // Always true
                analytics: this.preferencesModal.find('input[name="analytics"]').is(':checked'),
                marketing: this.preferencesModal.find('input[name="marketing"]').is(':checked')
            };

            this.setPreferences(preferences);
        },

        setPreferences: function(preferences) {
            const self = this;

            $.ajax({
                url: this.params.ajaxUrl,
                method: 'POST',
                data: {
                    action: 'rr_cookies_save_preferences',
                    nonce: this.params.nonce,
                    ...preferences
                },
                success: function(response) {
                    if (response.success) {
                        self.setCookie('rr_cookies_preferences', JSON.stringify(preferences), self.params.cookieDuration);
                        self.hideBanner();
                        self.hidePreferences();
                        self.applyPreferences(preferences);
                    }
                }
            });
        },

        setCookie: function(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
        },

        hideBanner: function() {
            this.banner.removeClass('show');
            setTimeout(() => {
                this.banner.remove();
            }, 300);
        },

        applyPreferences: function(preferences) {
            // Trigger custom event for other scripts to handle
            $(document).trigger('rrCookiesPreferencesUpdated', [preferences]);
        }
    };

    $(function() {
        RRCookies.init();
    });

})(jQuery);
