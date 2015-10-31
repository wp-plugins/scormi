=== Plugin Name ===
Plugin Name: Scormi - Google Analytics Insights
Plugin URI: http://scormi.net
Description: Scores your blog post engagement strength.
Tags: Google Analytics, Digital Marketing Analytics, Scorecard
Author: Aleksey Korenkov, Dave Goodwin
Author URI: http://scormi.net
Contributors: Alex, Dave
Requires at least: 4.0
Tested up to: 4.3.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Scores your blog post engagement strength.

== Description ==
Scormi displays key Google Analytics data and calculates a quality score for your top 10 blog posts (see screen shot). Knowing this can help you shape your content for better user engagement. Scormi works best for sites with more than 100 visitors/day spread over your posts. It won't be useful for sites with minimal traffic or sites where traffic goes to less than 10 pages because there isn't enough data to work with.

Use a shortcode to view the report on a publicly accessible (protected) WordPress page or view it in the WP admin. 

Report metrics include:

* Sessions & corresponding last year sessions
* Year over Year traffic growth % 
* Return visits %
* Top 10 pages with Sessions, Bounce Rate, Average Time on Page, Quality score.
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
1. Shortcode instructions are in Scormi>Settings.


= How it Works =
After you authenticate with Google Analytics the plugin requests your information once per night. The request is sent to our server, which connects to GA via API, gathers the info, does the quality score calculations, renders an HTML report, and returns it to the plugin. The report is cached in WordPress between updates for quick loading. 

== Frequently Asked Questions ==
= For whom is this plugin intended ? =
For WordPress blogs with at least 100 visitors per day and one year of Google Analytics data history.

= Can Scormi see my Google credentials? =
No. You sign into Google using their OAuth 2 secure login and Google Analytics gives you an access token for Scormi to use.

= The report doesn’t look right on a smartphone. = 
The report uses Bootstrap 3 and has been built to work correctly with the standard WordPress theme. Using a 3rd party theme that is not mobile responsive or has CSS idiosyncrasies can cause formatting issues on small screens.

= What's the math behind the quality scorecard? =
Basically it bell curves your posts. See the Blog Post Quality Scorecard post at Scromi.net for the details.

== Screenshots ==
1. Scormi report in the WordPress admin.
2. The Scormi report is fully responsive for mobile devices. 

== Changelog ==

Version 3.1 - Release Date 25 Oct 2015

* Introduced blog post engagement score
* Removed Avg Page Load Time

Version 3.0.1 - Release Date 5 Sep 2015

* Added shortcode use instructions to settings page

Version 3.0 - Release Date 3 Sep 2015

* Introduced responsive CSS analytics report
* Revised Google Analytics metrics and dimensions
* Eliminated Mozscape data
* Changed the main graph to line graph

Version 2.0 - Release Date 2 August 2015

* Added report date ranges.
* Changed the main graph to area graph.

Version 1.0 - Release Date 13 June 2015

* Plugin released.

