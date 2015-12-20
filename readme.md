# Sainsbury product crawler

Sainsbury product crawler is an application which crawls the category page of Sainsbury's testing webpage and returns the results in json format.
The result in json has each product's title, size of product's inner page in KB, product's description and the total price of all products.

This application is based on MVC.
The default controller is located in Application/Controllers/Sainsbury.php
The model for this application is located in Application/Models/Parser_model.php
The view for this application is located in Application/Views/sainsbury_view.php

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
 - Open cmd and point to the application's root folder
 - Type php index.php in cmd and get the results

```sh
$ php index.php
```

### Unit Testing

$ Unit testing is a controller located in Application/Controlles. The class name is Test and the function is test_price. You can directly hit <<path_to_application>>/test/test_price