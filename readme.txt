=== Plugin Name ===
Plugin Name: Scormi - Google Analytics Insights
Plugin URI: http://scormi.net
Description: Mobile friendly Google Analytics insights.
Tags: Google Analytics, Digital Marketing Analytics 
Author: Aleksey Korenkov, Dave Goodwin
Author URI: http://scormi.net
Contributors: Alex, Dave
Requires at least: 4.0
Tested up to: 4.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Mobile friendly Google Analytics insights.

== Description ==
Our goal with the plugin is to give you actionable information that can be used to make business decisions. Using the acquisition information below gives you a good picture of where visitors are coming from and how well your content is performing. Choose report date ranges for the past 7, 30, 60, or 90 days. Scormi works best for mature sites with over 100 visitors/day and at least 90 days of Google Analytics history. The report is mobile responsive so it works perfectly on a smartphone.

Report metrics include:

* Sessions & corresponding last year sessions
* Year over Year traffic growth % 
* Return visits %
* Top 10 pages with Sessions, Bounce Rate, and Avg. Page Load Speed
* Top 3 countries
* Traffic source by Organic, Direct, Referral, Social
* Top traffic sources by domain (who is driving traffic to your site)
* Top social media traffic sources and number of sessions (your footprint)

== Installation ==
To install and configure Scormi

1. Ensure that you have previously installed the Google Analytics tracking code.
1. Install the plugin by uploading it directly or via the automatic WordPress installer, then activate it.
1. Click on Scormi>Settings in the WP Admin menu on the left or under Installed Plugins and complete the settings info.
1. Select your desired report date range, from 7 to 90 days.
1. Click Scormi>Scormi in the WordPress Admin menu on the left to generate the report.

= How it Works =
The plugin requests your Google Analytics information once per night via API, then renders an HTML report. The report is cached in WordPress between updates for quick loading.

== Frequently Asked Questions ==
= Can Scormi see my Google credentials? =
No. You sign into Google using their OAuth 2 secure login and Google Analytics gives you an access token for Scormi to use.

= Can I use the plugin if my site has fewer than 100 sessions/day and less than one year of GA history? =
Yes but Google Analytics information with a small data set (100 per day being borderline) will result reporting gaps for some report items such as Page Load Time. This is due to GA’s use of data sampling for some metrics.

== Screenshots ==


== Changelog ==

Version 3.0 - Release Date 3 Sept 2015

* Introduced responsive CSS analytics report
* Revised Google Analytics metrics and dimensions
* Eliminated Mozscape data
* Changed the main graph to line graph

Version 2.0 - Release Date 2 August 2015

* Added report date ranges.
* Changed the main graph to area graph.

Version 1.0 - Release Date 13 June 2015

* Plugin released.

