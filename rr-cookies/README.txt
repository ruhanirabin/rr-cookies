=== RR Cookies ===
Contributors: ruhanirabin
Tags: cookies, gdpr, ccpa, cookie consent, privacy
Requires at least: 6.5
Tested up to: 6.5
Requires PHP: 8.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A comprehensive cookie consent management solution for WordPress.

== Description ==

RR Cookies provides a flexible and customizable cookie consent management system for WordPress websites. It helps you comply with GDPR, CCPA, and other privacy regulations.

Features:

* Customizable cookie consent banner
* Detailed cookie preferences management
* Multiple banner positions and animations
* Dark and light themes
* Custom colors and styling
* Translation ready
* Developer-friendly API
* GDPR and CCPA compliant

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/rr-cookies`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Configure the plugin settings under 'RR Cookies' in the admin menu

== Frequently Asked Questions ==

= Is this plugin GDPR compliant? =

Yes, RR Cookies is designed with GDPR compliance in mind, allowing users to manage their cookie preferences.

= Can I customize the appearance? =

Yes, you can customize colors, positions, animations, and text content through the admin interface.

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of RR Cookies.

== Developer Documentation ==

=== API Functions ===

Check if a cookie type is allowed:
`RR_Cookies_API::is_cookie_allowed('analytics')`

Get user preferences:
`RR_Cookies_API::get_user_preferences()`

=== Filters ===

Modify cookie types:
`add_filter('rr_cookies_consent_types', function($types) { return $types; });`

Customize banner content:
`add_filter('rr_cookies_banner_content', function($content) { return $content; });`

=== Actions ===

Before saving preferences:
`add_action('rr_cookies_before_save_preferences', function($preferences) {});`

After saving preferences:
`add_action('rr_cookies_after_save_preferences', function($preferences) {});`
