<?php

class Sainsbury extends CI_Controller {

    public $view_data;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('parser_model');
    }
    public function index() {
        
        $fetched_content = json_encode(array_values($this->parser_model->get_products_result()),true);
        $this->view_data['content'] = $fetched_content;
        $this->load->view('test_view', $this->view_data);
        
    }

}
