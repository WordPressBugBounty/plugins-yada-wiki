=== Yada Wiki ===
Contributors: dmccan
Tags: wiki, shortcode, internal links, page links, faq, knowledge base
Requires at least: 4.1
Tested up to: 6.5
Stable tag: 3.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Yada Wiki is a simple wiki for your WordPress site.

== Description ==
Yada Wiki provides a wiki post type, custom tags and categories, an index, and a table of contents option.  The plugin allows you to link your wiki pages together using the wiki page titles.  

There are two easy to use shortcode buttons available on the editor toolbar.  Rather than try to remember the shortcodes and their values, it is recommended that you use these buttons to generate the shortcodes for you.

**The "Add Wiki Link" Button:**
When you click the first button, the add wiki link button, a pop-up opens where you enter the title of the wiki page you are linking to in the "Link" text box.  You can optionally enter text into the "Show" text box that you want to show for the link, or leave that blank to just show the title.  There is the ability to manually add an "anchor" parameter for on-page links.  Please see the documentation for more information on this. 

When you click "OK", a shortcode is inserted into your edit window at the cursor location.  For example to link to a wiki page called "How To Make Iced Coffee" but show the text for the link as "How To Make My Favorite Drink":

[yadawiki link="How To Make Iced Coffee" show="How To Make My Favorite Drink"]

You use Wiki Link shortcodes to create the structure of linked pages.

**The "Add Wiki Listing" Button:**
The Add Wiki Listing button gives you three options for adding some collected output. 

*Output TOC Page*
The first option inserts a shortcode that will output your "TOC" page. With Yada Wiki, you can create a special wiki page with the title of "TOC" that will serve as the table of contents for your wiki.  You can use wiki links and style the table of contents as you like in the post editor. Selecting this option allows you to embed the TOC page in another page. For example:

[yadawikitoc show_toc="true"]

*Output Wiki Category*
The second option inserts a list of the wiki pages for one of your wiki categories. You can optionally choose to output the list by title or by creation date.  For example:  

[yadawikitoc show_toc="true" category="Drinks" order="title"]

*Output Index*
The third option inserts a grid of your wiki pages or categories.  The output is in a responsive table-like grid and you can choose the number of columns.  For example, to output wiki pages:

[yadawiki-index type="pages" columns="4"]

An example for listing a single wiki category by title:

[yadawiki-index type="category-name" category="States" columns="3"]

An example for listing all wiki categories by title:

[yadawiki-index type="all-categories-name" columns="3"]
Note that in the index listing the category hierarchy only goes down one level deep from to the top.  

**Sidebar Widgets:**
There are two Yada Wiki widgets. One for showing the TOC page and a list of article titles for a given category in the sidebar and the other for showing recent wiki articles.  Please see the FAQ section for information about using the sidebar widgets. 

**Documentation:**
Documentation is available at https://www.webtng.com/yada-wiki-documentation/

The FAQs below also have good information.

**Video Walk-through:**
This video provides a walk-though of all of the features:

https://youtu.be/yixVePH3IpA

** Translations **
The plugin is available in:
* English
* Spanish

== Installation ==
You can install the Yada Wiki plugin either via the WordPress.org plugin directory or by uploading the files to your server.  Once the plugin is installed, you can activate the plugin through the Plugins menu in WordPress.

== Screenshots ==
1. These are the editor buttons for the Yada Wiki shortcodes.  

== Frequently Asked Questions ==
= Why are some wiki links red? =

When viewing wiki pages, if the wiki page exists it shows as a link.  If it does not exist, and the user has permissions to edit posts, then the link shows up in red to indicate that the page needs to be created.  You can click on the link to go to the page editor to create the new page.  If the user does not have permissions, then they see the title in red, but no link is available.

= Can I include external links and links to non-wiki pages in my wiki? =

Yes, but the wiki shortcode is only for linking to wiki pages.  If you want to link to external sites or regular posts or pages, then use the usual methods in the post editor to do so, but not the Yada Wiki shortcode.

= Can I use the wiki shortcode in non-wiki posts and pages? =

Yes, there is a Yada Wiki sub-menu under the main settings menu where you can enable showing the Yada Wiki shortcode buttons when editing posts and pages.  Remember, the wiki shortcode is only for linking to wiki pages.

= How can I add a wiki table of contents menu in the sidebar? =

There is a sidebar widget so that you can include the TOC or a category list of wiki articles. It is a multi-instance widget so you can have more than one version of the widget active at a time.

= How can I show recent wiki articles in the sidebar? =

There is now a recent activity widget so that you can include a list of the most recent wiki articles.  You may optionally show the how long ago it was modified.  

= Does Yada Wiki work with Page Builder plugins? =

Most page builders allow you to enter shortcodes and the Yada Wiki shortcodes should work. If the shortcodes do not work then let me know and I'll take a look. The sidebar widget works well in regular widget areas, but may not work when embedded using page builders (except for Beaver Builder - see below). 

The plugin has been tested and updated to work with Beaver Builder. By default Beaver Builder does not show 3rd party buttons in the Text Editor module, but you can enter the shortcodes manually. The sidebar widget works with the Beaver Builder widget module. 

= Can I nest shortcodes or include multiple TOC Category shortcodes on the same page? =

You can include regular wiki link shortcodes in your TOC.  You can also add multiple TOC Category shortcodes to a regular wiki page.  Adding TOC shortcodes to the TOC page, or adding TOC Category shortcodes to the TOC page does not work.

= Why don't I see all of the categories when I output an index of categories? =

Empty categories, with no wiki pages or child categories assigned, are excluded.  Also, the index of a category or all categories only goes down to one level of child categories.  

= Why is there the option to sort the category index by slug? =

Some people may have categories that are people's names, such as book authors.  The alternate ability to sort by slug gives some flexibility for custom sorting if, for example, you use the author's last name for the slug.  

= How can I display the custom tags and categories? =

You can use the tag cloud widget to display the wiki custom tags. There are also plugins in the WordPress repository that will allow you to display custom categories (or taxonomies).  

= How do I control comment options? =

Yada Wiki does not support comments by default.  There is a Yada Wiki sub-menu under the main settings menu where you can enable comment options and set defaults for new wiki pages.

= After upgrading the plugin the wiki editor buttons are gone. How do I get them back? =

The way the buttons are loaded was changed in version 2.  If you do not see the buttons you may need to clear your browser cache.  

= Is the plugin compatible with WordPress multisite? =

The plugin is not compatible with multisite.  

= Can I use custom permalinks? =

The wiki links are based on links to wiki page titles, so it is expected that you will use the "Post name" type of permalink structure.  You can change the URL slug for links from 'wiki' to another word of your choice on the Yada Wiki settings page. 

= How can I change the colors of the wiki links? =

When rendered on the viewed page, wiki links are given a CSS class related to their post status (published, draft, etc). You can override the default colors in your style sheet. This is a convenience for those with edit permissions who might not realize that wiki articles have not been published. Note that WordPress permissions still control what posts can actually be viewed, this is just related to the display of wiki links. The classes are:

When viewing links for users **with** the "edit_posts" capacity:

  * .wikilink-new (post does not exist - a link to create it)
  * .wikilink-trash (post is in the trash - just text, no link)
  * .wikilink-pending (post has the status of "draft", "auto-draft", "pending", or "future" - a regular link)
  * .wikilink-private (post has a status of "private" - a regular link)
  * .wikilink-published (the post is published - a regular link)
  * .wikilink-other (default if not one of the above. Applied to posts with a custom post status or to those with a status of "inherit" - a regular link)
  
When viewing links for users **without** the "edit posts" capacity:  

  * .wikilink-no-edit (post does not yet exist or the post has the status of "trash", "draft", "auto-draft", "pending", or "future" - just text, no link)
  * .wikilink-published (the post is published - a regular link)
  * .wikilink-private (post has a status of "private" - a regular link)
  * .wikilink-other (default if not one of the above. Applied to posts with a custom post status or to those with a status of "inherit" - a regular link)
  
= How can I style the TOC Output Wiki Category shortcode output? =

The TOC Output Wiki Category shortcode outputs an unordered list. 

  * The "ul" tag has a class of "wiki-cat-list" 
  * The "li" tag has a class of "wiki-cat-item" 
  * The link to the category in the "li" tag has the class of "wiki-cat-link"
  
= Is the plugin compatible with Gutenberg? Can I use it with the Gutenberg editor? =

As of Yada Wiki version 3.1, the Gutenberg editor is disabled on Wiki pages by default. There is a setting to enable it, but there are no Wiki blocks and no buttons to make it easier to add shortcodes.  
  

== Acknowledgements ==

The user @JulianSMoore has been very helpful in suggesting improvements and reviewing changes. Thanks to the user @simplyletgo who contributed the recent wiki post widget.  

== Changelog ==

= 3.5 = 
* Fixed shortcode index options which were not working correctly.
* Added esc_url() to some wiki post permalinks where it was missing. 
* Tested Yada Wiki for compatibility with WordPress 6.5. 

= 3.4.3 = 
* Update Yada Wiki for compatibility with WordPress 6.2. 

= 3.4.2 = 
* Update Yada Wiki TOC widget for compatibility with Thrive Architect. 

= 3.4.1 = 
* Filtered shortcode "anchor" attribute to prevent cross-site scripting. 

= 3.4 = 
* Added option for wiki pages to be hierarchical and have a page order set.  Be careful changing this setting on a site where the wiki already has content. 

= 3.3 = 
* Added processing of optional "anchor" parameter to the wikilink shortcode

= 3.2.7 = 
* Added shortcode option to display category by date descending

= 3.2.6 = 
* Fixed BBPress support

= 3.2.5 = 
* Back out BBPress changes

= 3.2.4 = 
* Added Yada Wiki widget support for BBPress pages so Yada Wiki widgets will render in the sidebar

= 3.2.3 = 
* Tested for WordPress 5.4
* Handle occasional JavaScript error from the editor popup

= 3.2.2 =
* Added nonce to AJAX lookup

= 3.2.1 =
* Fixed tests for empty variables

= 3.2 =
* Added ability to translate Yada Wiki
* Added Spanish translation (note: JavaScript files are not yet translated)
* Added REST API support for wiki categories and tags
* Added recent activity widget (code contributed by @simplyletgo)
* Added placeholder output message for TOC tag when no TOC page is found or it is empty. 

= 3.1 =
* A step towards an Object Oriented version. 
* Added support for the Rest API so that it is possible to use Gutenberg. Added a setting to enable Gutenberg if desired. There is currently no other support for Gutenberg.

= 3.0 =
* Added the ability to change the plugin URL slug from the settings page. @Earl_D and others have suggested this. 
* Fix: Added function name prefix to avoid conflict with another plugin. Thanks to @wealthgizmo for pointing out this issue. 

= 2.9.1 =
* Added classes for TOC Category shortcode output. Thanks to @Earl_D for the suggestion. 
* Formatted the FAQ section of the readme. 

= 2.9 =
* Fixed issue of incorrect category links in certain cases by switching from the get_page_link function to the get_post_permalink function. Thanks to user @neverwinter. 
* Added default values to avoid errors. 
* Changes and testing to work with Beaver Builder. Updated the FAQ in relation to Page Builder plugins. 

= 2.8 =
* Added the option to output an index of a category or categories and sort them by name or slug.  The slug option allows for custom sorting. 
* Fixed issue with uneven columns on index pages.  Thanks to @caskets for the fix.
* Tweaks to make sure that the TOC shortcode dialog reset to defaults if used more than once on the same page.
* Updated the FAQ with some information about outputting an index of categories.

= 2.7 =
* Added the index shortcode option which outputs a grid of wiki pages using a responsive table-like format.
* Added help text to the Links pop-up dialog.
* Added help text to the TOC pop-up dialog.
* Separated the TOC options in the TOC pop-up dialog, showing and hiding options depending on the type of output desired so as to make the choices more obvious. 
* Reworked the read me file to simplify the description section, add shortcode examples, and provide a link to a walk-through video.  

= 2.6.3 =
* Fixed TOC category output for shortcode and widget.

= 2.6.2 =
* Updated widget constructor so as to remove PHP 7 deprecation warning. 

= 2.6.1 =
* Fixed post status filter so all posts show as they should.
* Added additional CSS classes.  

= 2.6 =
* Added different CSS classes for wiki links depending on post status.  Added style sheet for wiki link classes.
* Added option to show Yada Wiki editor buttons on the editing screen for all post types, in addition to the wiki post type.

= 2.5.1 =
* Update to get files in sync and fix tagging error.

= 2.4.0 =
* Added filter to override default display of categories in the post editor to maintain order and hierarchy.
* Fixed problem with shortcode pop-up display due to conflict with other plugins.

= 2.3.0 =
* Adjusted version number to keep updates in sync.

= 2.2.0 =
* Added optional support for comments.
* Added a settings page to control comment options for wiki pages.
* Removed old style PHP constructor in preparation for 4.3.
* Fixed deprecated function calls that gave a debug warning.

= 2.1.0 =
* Adjusted user permissions so that roles have the same edit abilities for wiki articles as they do for regular posts.

= 2.0.0 =
* Changed the editor dialogs to be in-line jQuery UI dialogs. 
* The links dialog has an AJAX look-up of existing wiki post titles.
* The TOC dialog has a drop-down list of categories.
* A sidebar TOC / category list widget was added.

= 1.2.0 =
* Added editor dialog to make it easier to enter the wiki shortcode parameters

= 1.1.0 =
* Change to make wiki categories hierarchical

= 1.0.1 =
* Fix for empty post type

= 1.0 =
* Initial release