=== Plugin Name ===
Plugin Name: Scormi for Google Analytics & Moz
Plugin URI: http://scormi.net
Description: Automatically creates a daily, sharable web analytics report from your Google Analytics and Moz info.
Tags: Google Analytics, Moz, StatCounter, Web Analytics, SEO, Mozscape, MozTrust, Domain Authority, API, Page rank, Alexa, Analytics Report, tools, automation, keywords, meta keywords, webmaster tools, google webmaster tools, seo pack, most popular pages, referrer spam, geo location.
Author: Aleksey Korenkov, Dave Goodwin
Author URI: http://scormi.net
Contributors: Alex, Dave
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically creates a daily, sharable web analytics report from your Google Analytics and Moz info.

== Description ==
A time saving automation tool for digital marketers, Scormi creates a daily web analytics report for your site via Google Analytics and Mozscape APIs. Set the report to be automatically emailed to you or view it in the WordPress admin any time. 

Includes

* Visitors & Unique Pageviews
* Top 10 Landing pages with associated Users, Pageviews, New vs Returning, & Bounce rate
* Visitor Desktop, Tablet, Mobile breakdown
* Top 3 countries
* Traffic sources: Organic, Direct, Referral, Social
* Your site’s MozRank, Domain Authority, and the number of equity links (back links) to your site.

== Installation ==
To install and configure Scormi

1. Install the plugin by uploading it directly or via the automatic WordPress installer, then activate the plugin.
1. Click on Scormi>Settings in the WP Admin menu on the left or under Installed Plugins and complete the settings info.
1. Click Scormi>Scormi from the WordPress Admin menu on the left to generate the report.

= How it Works =
The plugin requests your Google Analytics and Moz information once per night via API to these services. It then renders an HTML report  that can be set to auto-email to you and/or is always viewable in the WordPress admin. The report provides a high-level snapshot and is fully automatic; there are no user settings to configure.

== Frequently Asked Questions ==
= Can Scormi see my Google credentials? =
No. You sign into Google using their OAuth 2 secure login and Google Analytics gives you an access token for Scormi to use.

= I don’t have a Moz account, how does that work? =
Mozscape information is publicly available; no user credentials or setup is required.

= How much of my Google Analytics info does Scormi retain for its own use? =
None. We do not use a database to create the report. It is created directly from API calls.

= Addition FAQs =
http://scormi.net/faq/

== Screenshots ==
1. WordPress admin version of Scormi report 
2. Mobile email version of Scormi report

== Changelog ==

Version 1.0 

* Release Date 13 June 2015
* Plugin released.