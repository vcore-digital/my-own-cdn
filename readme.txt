=== My Own CDN ===
Plugin Name: My Own CDN
Contributors: vanyukov, myowncdn
Tags: cdn, fastly, bunny.net, cachefly
Requires at least: 6.0
Requires PHP: 7.4
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

CDN made simple for effortless performance.

== Description ==

CDN made simple for effortless performance.

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Follow the instructions in the setup wizard through the 'MyOwnCDN' menu in WordPress
4. Enjoy

== Frequently Asked Questions ==

= How does this work? =

Select a provider, use their services as needed, and simply pay the provider’s rate based on your actual usage. No hidden fees, no minimums — straightforward, pay-as-you-go access.
If you prefer a prepaid plan - no problem, we have several options for you as well.

= Can I switch providers at any time? =

Absolutely! You have full control—switch or pause your setup whenever you need, with complete flexibility.

== External services ==

This plugin connects to an API to obtain details about the connected CDN provider, it's needed to obtain the CDN domain that is used to pull assets from the site, as well as maintain an accurate status of the service.

It sends the site URL every time a user updates the CDN status via the plugin settings, as well as via the daily cron action. This is required to obtain the latest status of the CDN service.
This service is provided by "vCore Digital Pty Ltd" (doing business as MyOwnCDN): <a href="https://myowncdn.com/terms-of-service">terms of use</a>, <a href="https://myowncdn.com/privacy-policy">privacy policy</a>.

== Screenshots ==

1. Plugin options and settings

== Changelog ==

= 1.0.0 - 01.12.2024 =

First release

* Bunny.net support
* CacheFly support
* Fastly support
* Gcore support
