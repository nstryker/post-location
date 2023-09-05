=== Post Location ===
Contributors: nstryker
Tags: location,maps,Google maps,embeded map
Tested up to: 6.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress plugin for adding a Google Map to posts.

== Description ==

This plugin creates a metabox on post pages allowing you to add a Google Maps compatable location to a post. If valid, a map is embeded just after the_content.

== Installation ==

1. Upload Post Location to the `/wp-content/plugins/` directory or upload a zip via Plugins -> Add New
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings -> Post Location. Follow the link to set up a Google API Key (go to Credentials -> Create Credentials if you need to create a new one).
4. Paste the Key from the SHOW KEY link into the API Key settings field.
5. Go to a post and enter an address into the Post Location box on the right side.
6. Once the post is published or updated, the post will include a map of the location below the content.

== Changelog ==

= 0.1.2 =
* Track assets.

= 0.1.1 =
* Remove vendor from tracking.

= 0.1.0 =
* Complete refactor of the plugin using the [this WordPress plugin boilerplate](https://github.com/saucal/WordPress-Plugin-Boilerplate) as structural inspiration.

= 0.0.1 =
Basic plugin adds an options screen to settings, a meta box to the post edit screen, and Map to the end of the_content.

= 0.0.0 =
* Initial Commit.

== Hopes and Dreams ==

* Move Map into a Gutenberg block if available.
* Better in-WordPress instructions.
* Go after TODOs
* Compress CSS
* Separate templates
* Allow for different post types.
* Allow for custom map icon upload.
