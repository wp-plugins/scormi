=== Plugin Name ===
Plugin Name: Scormi for Google Analytics & Moz
Plugin URI: http://scormi.net
Description: Your top Google Analytics metrics and Moz SEO footprint every day, automatically.
Tags: Google Analytics, Moz, StatCounter, Web Analytics, SEO, Mozscape, MozTrust, Domain Authority, API, Page rank, Alexa, Analytics Report, SEO pack, most popular pages, referrer spam.
Author: Aleksey Korenkov, Dave Goodwin
Author URI: http://scormi.net
Contributors: Alex, Dave
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Your top Google Analytics metrics and Moz SEO footprint every day, automatically.

== Description ==
A time saving automation tool for digital marketers, Scormi creates a daily, sharable web analytics report from your Google Analytics and Moz information. The plugin uses APIs to connect to Google Analytics and Moz, then generates an HTML report that can be automatically emailed to you or can be viewed in the WordPress admin at any time.

The report contains Google Analytics information and Mozscape information from the current update. Choose report date ranges of the past 7, 30, 60, or 90 days. Report metrics include:

* Visitors & Unique Pageviews
* Top 10 Landing pages with associated Users, Pageviews, New vs Returning, & Bounce rate
* Desktop, Tablet, Mobile breakdown
* Visitor Top 3 countries
* Traffic sources: Organic, Direct, Referral, Social
* Your site’s MozRank, Domain Authority, and the number of equity links (back links) to your site.

== Installation ==
To install and configure Scormi

1. Ensure that you have previously installed the Google Analytics tracking code.
1. Install the plugin by uploading it directly or via the automatic WordPress installer, then activate it.
1. Click on Scormi>Settings in the WP Admin menu on the left or under Installed Plugins and complete the settings info.
1. Select your desired report date range, from 7 to 90 days.
1. Click Scormi>Scormi in the WordPress Admin menu on the left to generate the report.

= How it Works =
The plugin requests your Google Analytics and Moz information once per night via API to these services. It then renders an HTML report  that can be set to auto-email to you and/or is always viewable in the WordPress admin. The report provides a high-level snapshot and is fully automatic; there are no user settings to configure. The report is cached in WordPress between updates for quick loading.

== Frequently Asked Questions ==
= Can Scormi see my Google credentials? =
No. You sign into Google using their OAuth 2 secure login and Google Analytics gives you an access token for Scormi to use.

= What is Moz(scape)? =
Moz is a company that collects and provides website and web page popularity information--an "SEO footprint." Mozscape is their database of this information, which is publicly available; no user credentials or setup is required. The information on the Scormi report is helpful in tracking your SEO strength.

= Addition FAQs =
http://scormi.net/faq/

== Screenshots ==
1. WordPress admin version of Scormi report
2. Mobile email version of Scormi report

== Changelog ==

Version 2.0 - Release Date 2 August 2015

* Added report date ranges.
* Changed the main graph to area graph.

Version 1.0 - Release Date 13 June 2015

* Plugin released.
