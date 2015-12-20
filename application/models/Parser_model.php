<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parser_model
 *
 * @author George-pc
 */
class Parser_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Load the Simple_html_dom.php Library to use the Simple HTML DOM Parser
        $this->load->library('Simple_html_dom.php');
    }

    /**
     * Fetches the url from the official sainsbury online catalogF
     * 
     * @param string $url
     * @return array
     */
    public function get_products_result($url = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html') {
        //Initialize the $result array and $total var to save the products and calculate the total price
        $result = array();
        $total = 0;

        //Get the html from the given URL
        $html = file_get_html($url);

        //All products are <li> elements with parent the <ul> element with class name productLister listView
        //In $li var we save the DOM tree of our products
        $products = $html->find('ul[class=productLister listView] > li');

        //For each product 
        foreach ($products as $product) {
            //We use a temp array to store our variables and then we push it into the $result array
            $temp = array();

            //The information we need for the url of the inner page and the title is located in an <a> element with an <h3> element as parent
            $title_info = $product->find('h3 > a')[0];
            $product_href = $title_info->href;

            //Get product name
            $product_title = $this->get_product_title($title_info);

            //We use 2 functions to get the size in KB of the inner page of the product
            $size_in_kb = $this->formatSizeUnits($this->get_remote_size($product_href));

            //Get the description of the product
            $product_description = $this->get_product_description($product_href);

            //Get product price
            $product_price = (double) $this->get_product_price($product);

            //Calcurate the total price
            $total += $product_price;

            //Add values to temp array and push it into results
            $temp['title'] = $product_title;
            $temp['size'] = $size_in_kb;
            $temp['description'] = $product_description;
            $temp['unit_price'] = $product_price;

            array_push($result, $temp);
        }
        //Add the total to the result array. Because the example has no keys for each product, we use twice the total key, so we can use array values when we call it.
        //In that way we can have each json element without key and the last element will have the key total
        $result['total'] = array('total' => $total);
        return $result;
    }

    private function get_product_title($title_info) {
        //Get the inner text of the product's title
        $product_title = $title_info->innertext;
        //Trim spaces and remove the image element.
        $product_title = trim(substr($product_title, 0, strpos($product_title, "<img")));

        //return product's name
        return $product_title;
    }

    /**
     * 
     * @param type $product
     * @return type double
     */
    private function get_product_price($product) {
        //The price is located in a <p> element with class pricePerUnit
        $price = $product->find('p[class=pricePerUnit]')[0];
        //Get the text of the element
        $product_price = $price->innertext;
        //Clear the price and remove the Symbol &pound;.
        $product_price = trim(substr($product_price, 0, strpos($product_price, "<abbr")));
        $product_price = str_replace('&pound', '', $product_price);

        //return product's price 
        return $product_price;
    }

    /**
     * 
     * @param type $url
     * @return type string
     */
    private function get_product_description($url) {
        //Get the HTML page of the product
        $product_page = file_get_html($url);
        //find the description located in div with class productText
        $description = $product_page->find('div[id=information] > div[class=productText]');
        //only the first child has the description of the product
        $product_description = $description[0]->innertext;
        //clear string
        $product_description = trim(str_replace(array('<p>', '</p>'), ' ', $product_description));

        //return the description
        return $product_description;
    }

    /**
     * 
     * @param type $url
     * @return type integer
     */
    public function get_remote_size($url) {
        //This function gets only the headers of the given url. This is way faster than get_contents because it gets only the headers
        $headers = get_headers($url, 1);
        if (isset($headers['Content-Length']))
            return $headers['Content-Length'];
        if (isset($headers['Content-length']))
            return $headers['Content-length'];

        //if there is no Content length in the headers array, curl and get the size_download of the html
        $c = curl_init();
        curl_setopt_array($c, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'),
        ));
        curl_exec($c);
        return curl_getinfo($c, CURLINFO_SIZE_DOWNLOAD);
    }

    /**
     * 
     * @param type $bytes
     * @return string
     */
    public function formatSizeUnits($bytes) {
        //This function converts the given bytes to byte,bytes,KB,MB,GB etc, regarding the specific size
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

}
