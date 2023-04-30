# post-location
WordPress plugin for adding a Google Map to posts.

## Description

This plugin uses the Google Maps API to add a simple map to a post in WordPress. Works with or without the Classic Editor plugin.

## Installation

1. Install and activate the plugin.
2. Go to Settings -> Post Location. Follow the link to set up a Google API Key (go to Credentials -> Create Credentials if you need to create a new one).
3. Paste the Key from the SHOW KEY link into the API Key settings field.
4. Go to a post and enter an address into the Post Location box on the right side.
5. Once the post is published or updated, the post will include a map of the location below the content.

## Changelog

### 0.0.1
* Basic plugin adds an options screen to settings, a meta box to the post edit screen, and Map to the end of the_content.

### 0.0.0
* Initial Commit.

## Hopes and Dreams

* Code refactor.
* Better in-WordPress instructions.
* Check for valid address.
* Allow for different post types.
* Allow for custom map icon upload.
* Move Map into a Gutenberg block if available.
