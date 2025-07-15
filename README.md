# Wordpress Accordion
A WordPress plugin that allows users to edit the names of post categories and sort them within a dropdown menu.

# Description
Technology Used: WordPress, HTML, CSS, JavaScript, jQuery, PHP, and MySQL.

The plugin displays the category names and post names of articles in a WordPress blog. These names are displayed using a jQuery accordion, which is a CSS modal dropdown menu. This accordion allows users to modify the names of a category and save, using JavaScript form validation to verify valid names.

# Known Bugs
At the later stage of development, an issue emerged which occurred when a user would sort the list of headings, the page wouldn't automatically refresh. This issue was fixed only by reloading the page manually, but attempts to fix this bug primarily relying on reloading the page with JavaScript did not resolve this issue, so it is assumed that this issue may be a server-side issue which using PHP may debug.

# How to run
The plugin was developed using a virtual environment on a local Windows machine. The following programs must be installed to run the plugin.

* Virtual Environment (Preferably Oracle’s VirtualBox)
* Vagrant
* Laravel Homestead
* WordPress
* phpMyAdmin
* MySQL

To download the instructions to install WordPress using Laravel Homestead, along with the other required software, click [here](https://github.com/user-attachments/files/21222285/WordPress.Download.Instructions.docx.pdf) to download the instructions PDF. After installing all the required software, you can upload the .php files which will allow you to use the accordion.
