=== CategoryTinymce ===
Contributors: ypraise
Donate link: http://ypraise.com/2012/01/wordpress-plugin-categorytinymce/
Tags: category description, wp_editor
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 1.5
Version 1.5

Provides the ability to add a fuly functional tinymce editor to the category and tag editor to style up the introductory information for category archives.

== Description ==

This plugin needs at least Wordpress 3.3 to work as it uses the new wp_editor call introduced in WP 3.3.

The CategoryTinymce plugin replaces the current category description box with one that has a fully active tinymce editor. 

By adding html formated text in the category description you can spoil the look of the category admin page so this lugin also removes the description column from the admin page to keep it looking nice and manageable.

The plugin has now been extended to include the tag description and admin screens.

There are no setting to configure just upload and  activate.



== Installation ==

1. Upload CategoryTinymce folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to your category edit pages and start to style them up.


== Frequently Asked Questions ==

= What exactly does this plugin do to my Wordpress instalation =

1. The plugin removes the default category description field.
2. It then adds in a new field that is fully tinymce enabled. I did try and just add an editor to the default field but I could not get it to function cvorrectly. The new field saves to the same database section as the default field so no new database tables or fields are added.
3. The plugin runs a filter on the category edit admin pages to remove the default description field as this broke up the admin table and made it unweildly.


= The plugin does not work =

The plugin in was tested on a clean install of wordpress 3.3 and a child theme of 2010. If the plugin does not work then raise a topic for this plugin and tell me: what version of wordpress you are using, what theme are you using, do you have problems with any other tinymce call in your theme.

= What does the future hold for CategoryTinymce =

There's a bit of tweaking needs doing but the main feature next is to only display the category description on the first page of the arhives so it is not repeated when you go to the next page in the archive. In the mean time you can use the following code to deal with the issue.

In category.php of your theme folder add:

					if (is_category() && $paged < 2) {
		echo '
		<p>'.category_description().'</p>';
	} 
	
	just before the get template part.
	
In tag.php of your theme folder add:

if (is_tag() && $paged < 2) {
		echo '
		<p>'.tag_description().'</p>';
	} 

	just before the get template part.

== Screenshots ==

1. A new tinymce enabled category description box is added to the categroy edit screen.
2. The category description box and column are removed form the admin page to keep it looking nice.


== Changelog ==

= 1.5 =
* tackled the parent category option bug and cleaned up some css code - thanks to Brightweb for fixes.

= 1.4 =
* support for custom taxonomies - thanks to Jaime Martinez for adapting the taxonomy call line.

= 1.3 =
* forced a button style css width to correct the one button per row bug in html quicktags.

= 1.2 =
* dealt with the issue that prevented setting parent categories..

= 1.1 =
* extened the plugin to include tags as there's been no issues raised with the basic category description plugin.

= 1.0 =
* The first flavour launched.


== Upgrade Notice ==

= 1.5 =
tackled the parent category option bug and cleaned up some css code - thanks to Brightweb for fixes.

= 1.4 =
Support for custom taxonomies.

= 1.3 = 
Corrected a missing css stlye for buttons in html quicktags.

= 1.2 =
Upgrade if you need to be able to set parent categories on the category admin pages.

= 1.1 =
Upgrade if you want to use the plugin on tag descriptions and pages.

= 1.0 =
None