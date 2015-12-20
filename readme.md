# Sainsbury product crawler

Sainsbury product crawler is an application which crawls the category page of Sainsbury's testing webpage and returns the result in json format.
The result in json has each product's Title, size of product's inner page in KB, product's description and the total price of all products.

### Version
0.1

### Technologies

Sainsbury product crawler uses a number of open source projects and libraries to work properly:

* [WAMP] - WampServer is a Windows web development environment. It allows you to create web applications with Apache2, PHP and a MySQL database.
* [PHP] - PHP version used is 5.5.12
* [CodeIgniter 3.0] - MVC framework
* [Simple HTML dom] - [@http://thephpx.com/2009/10/php-simple-html-dom-parser-codeigniter-integration/]
* [Unit Testing Class] - CodeIgniter’s Unit Test class.
* [Github] - a public repository for this application

### Installation

 - Create a virtual host for apache and php
 - Copy and save the project in root directory

### Run

To run it as console application
 - Open cmd and point to the sainsbury root folder
 - Type php index.php in cmd and get the results

$ php index.php

### Unit Testing

$ Unit testing is a controller located in Application/Controlles. The class name is Test and the function is test_price. You can directly hit <<path_to_application>>/test/test_price