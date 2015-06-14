=== Plugin Name ===
Plugin Name: Scormi for Google Analytics & Moz 
Plugin URI: http://scormi.net
Description: Easily view your Google Analytics activity and Moz SEO information with an automatic, daily report.
Tags: Google Analytics, Moz, StatCounter, Web Analytics, SEO, API, Page rank, website traffic.
Author: Aleksey Korenkov & Dave Goodwin
Contributors: Aleksey Korenkov & Dave Goodwin
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily view your Google Analytics activity and Moz SEO information with an automatic, daily report.

== Description ==
Scormi (Score Me) creates an easy-to-read, daily report from your Google Analytics and Moz information. The report can be viewed in the WordPress admin and automatically emailed to you if you enable this option.

Includes

* Number of Visitors & Unique Pageviews
* Top pages information
* Visitor locations and devices
* Traffic sources
* Your site’s MozRank, Domain Authority, and the number of equity links to your site.

= How it works =
1. Once per night the plugin requests your Google Analytics and Moz information from the Scormi server.
1. The server fetches the information via API and sends it to the plugin to be rendered into an HTML report.
1. The report is viewable in the WordPress admin and can be optionally emailed to the email address in Settings>General.

= Additional Info =
The plugin uses WordPress Cron, which fires only on a page visit. If there are no site visitors on a given day then the report will not run that day.

== Installation ==
This section describes how to install the plugin and get it working.

1. Install and activate the plugin from your WordPress Admin via the automated WordPress process.
1. Click on Scormi>Settings from the WordPress Admin menu and complete the setup.
1. Click Scormi>Scormi from the WordPress Admin menu to generate the report.

== Frequently Asked Questions ==
= Can Scormi see my Google credentials? =
No. You sign into Google using their OAuth 2 secure login and Google Analytics gives you an access token for Scormi to use.

= I don’t have a Moz account, how does that work? =
The Moz information on the report comes from publicly accessible “Mozscape” information and no user credentials or setup is required.

= How much of my Google Analytics info does Scormi retain for its own use? =
None. The report is created straight from the API data.

= Addition FAQs =
http://scormi.net/faq/

== Screenshots ==
1. WordPress admin version of Scormi report 
2. Mobile email version of Scormi report

== Changelog ==

Version 1.0 

* Release Date 13 June 2015
* Plugin released.