<?php

class Sainsbury extends CI_Controller {

    public $view_data;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('parser_model');
    }
    public function index() {
        
        //Get the result from parser_model, remove the array keys to meet the example of the pdf and encode it in json.
        //They array values is used to remove the 0,1,2.. keys from the array
        $fetched_content = json_encode(array_values($this->parser_model->get_products_result()),true);
        //Send results to test_view
        $this->view_data['content'] = $fetched_content;
        $this->load->view('sainsbury_view', $this->view_data);
        
    }

}
