# WooCommerce On Sale Information
* **Contributors:** apintocr
* **Tags:** woocommerce, ecommerce, e-commerce, sale, onsale, php7
* **Author URI:** https://www.vanguardly.com/
* **Plugin URI:** https://gitlab.com/vanguardly/wordpress/woocommerce-onsale-information/
* **Requires at least:** 4.9
* **Tested up to:** 5.3-alpha-45777
* **Stable tag:** 1.1.0

> Shows the sale end date on the product page. Works with simple and variable products.

## Description

This is a very simple plugin that shows the sale start and end date on the product page. Works with simple and variable products.

It's on the roadmap adding a couple of features like the discount percentage, however I do plan to keep this plugin very simple.

## Features

* Adds the Sale start date on the product price (near the price);
* Adds the Sale end date on the product price (near the price);
* Works with Simple and Variable Products;
* Allows for different discounts and dates per variation;
* Does not add any CSS;
* Lightweight;

## Installation

* Use the included automatic install feature on your WordPress admin panel and search for “WooCommerce On Sale Information”.
* Install and Activate the plugin.
* Done :)

## Frequently Asked Questions

### How can I style the sale information?

You will need to add custom css to your theme.
Currently there are 3 classes:

* .vgy_wcosi_wrapper for the wrapper of both start and end dates;
* .vgy_wcosi_sale_from_date for the start date;
* .vgy_wcosi_sale_end_date for the end date;

### Is this plugin compliant with the European Union General Data Protection Regulation (GDPR)?

This plugin does not collect or store any private data.

## Changelog
= 1.1.1 =
* Fixed Version Number (ops).

= 1.1.0 =
* Added support for sale start date.
* Fixed issue where the class names where not printed.
* Changed <span> to <div> so it appears on a new line.
* Updated tested up to WordPress 5.3-alpha-45777 and WooCommerce 3.7.0-rc.2.
* Minor tweaks to code.

= 1.0.2 =
* Updated tested up to WordPress 5.2.0 and WooCommerce 3.6.3.

= 1.0.1 =
* Fixed duplicated filter name.
* Removed language files from plugin files.
* Minor tweaks to code comments.

= 1.0.0 =
* Initial release.
