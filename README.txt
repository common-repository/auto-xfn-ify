=== Auto XFN-ify ===
Contributors: DavidMeade
Donate link: http://davidmeade.com/wordpress-plugins
Tags: XFN, links, blogroll, microformat, microformats
Requires at least: 2.0.2
Tested up to: 2.8.4
Stable tag: 1.2

Adds XFN rel attributes and CSS styles to links in your posts based on XFN values entered in the wordpress Links section.

== Description ==

This Plugin automatically adds XFN rel attributes to links contianed in your posts for any link that you have saved XFN values for in the Links section of the Wordpress Admin.  This way you don't have to add XFN info manually each time you link to someone in your posts.  The plugin uses the XFN data stored for links in the wordpress admin section, so as you update/add/remove links and any XFN data in your WP Admin section, all links on your site are automatically updated with appropriate XFN attributes.  The plugin can optionally (when theme supported) include XFN icons next to the appropriate links in your posts.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the entire `auto-xfn-ify` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Optionally turn on CSS styling for XFN links on the "Auto XFN-ify" page of the "settings" menu in WordPress.

== Frequently Asked Questions ==

= How does the plugin determin XFN data for a given link? =

It uses the "Link Relationship (XFN)" data set for links in the Links section of the Wordpress Admin.

= What about links that are not in my blogroll? =

This plugin only adds XFN data for links you've included in your blogroll.

= Doesn't wordpress do this already? =

Not within your posts' body.  This plugin will automatically add the XFN rel attributes within your blog posts when you include links to your sites/people in the Links section of your Wordpress Admin.

= What happens if I change the XFN data for a link in the WordPress admin? =

The new XFN data will automatically be used when displaying links to that url in any existing or future posts.

= What happens if I add a link with XFN data to the Links section of my Wordpress Admin? =

All existing and future links to that url in your posts will now automatically have XFN rel attributes added. 

= What happens if I remove a link with XFN data from the Links section of my Wordpress Admin? =

Links in your posts to a removed url will no longer be updated by this plugin, and thus no longer display any XFN data. 

= Will this plugin add appropriate XFN data to links that are marked 'private'? =

Yes. This plugin will add XFN data (if there is any) to any link that you include in your post that is also in your Link Magager - even 'invisible' or 'private' ones that wouldn't show up in an automated blogroll sidebar listing. 

= Does a link have to be marked "visible" in the Manage Links section? =

No. This plugin will add XFN data (if there is any) to any link that you include in your post that is also in your Link Magager - even 'invisible' or 'private' ones that wouldn't show up in an automated blogroll sidebar listing. 

== Changelog ==

= 1.2 =
* Improved regex for link replacement (Thanks, <a href="http://wordpress.org/support/profile/1345092">prometh</a>)
* Fixed issue where Style sheet option was not being honored (Thanks, <a href="http://wordpress.org/support/profile/1345092">prometh</a>)
* Included additional icons for: parent, child, and spouse relationships (Thanks, <a href="http://www.brianhanifin.com/">Brian Hanifin</a>)

