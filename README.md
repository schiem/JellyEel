# JellyEel

This is meant to be a very minimal core for building sites using PHP.  It's meant to provide a basis for when something like Wordpress would be gross overkill, but you don't want to write from scratch.  Hopefully it can be a framework for developers to build sites, instead of end users.

Currently it supports custom:

* [Config](#config)
* [Headers](#headers)
* [Pages](#pages)
* [Templates](#templates)
* [User accounts](#accounts)
* [Extensions](#extensions)
* Footers (coming soon, I completely forgot these);

## <a name='config'></a>Config
This repository comes with a file named config-sample.php.  Rename this file to config.php to use it in the project.  There are several sections:

###Database Block
Fill this section in with your database information.  This framework does not rely on a database for content, but does rely on a database for user accounts.

###Extensions Block
These are the enabled extensions in your project.  This will be covered more in depth in the extensions section.

###Site info block
This is where you change your site information.
* url : the url of your site
* name : the title of your site
* home\_slug : the name of the file in the page directory that you would like to use as your homepage
* core\_dir  : the place where your site core files live.  Don't change this unless you have a good reason to
* page\_dir  : the place where your pages live.  Don't change this unless you have a good reason to
* extension\_dir : the place where your extensions live. Don't change this unless you have a good reason to
* header\_dir : the place where your headers live. Don't change this unless you have a good reason to


## <a name='headers'></a>Headers

To start with, you'll probably want to create a header.  You can do this by creating a file in the header directory (defined in config.php).  To insert a header into a page, call the function `get_header()` with the optional argument of the header file name.  By default, it will look for the file `header.php`.

You can establish your own conventions for the header, although typically you would open the `<html>` and `<body>` tag, inserting the `<head>` in between.  Here you'll have access to any variables that have been placed in the array $header\_args, which is typically done before calling `get\_header()`.

For instance, a normal page would look like: 

```php 
<?php $header_args['title'] = 'My Awesome Page';
get_header();
?>
```

Inside of the header file, `$header_args['title']` will be available.

##<a name='pages'></a>Pages

Pages will likely make up the bulk of your site, as every different url you have will be a different page.  A typical page will consist of establishing variables, calling the header, then calling the page content with templates in it.
