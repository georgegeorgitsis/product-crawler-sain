<?php
/**
 * Description of Test
 *
 * @author George-pc
 */
class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('unit_test');
        $this->load->model('parser_model');
    }

    public function test_price() {

        $result = $this->parser_model->get_products_result();
        $result = (string)$result['total']['total'];

        $expected_result = (string)15.1;

        $test_name = 'Products total price';

        $this->unit->run($result, $expected_result, $test_name);
        var_dump($this->unit->result());
    }

}
