<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Catalog extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("catalog_model");
    }

    public function index(){
        $this->page_title = 'Catalog Download';
        $data['categories'] = $this->catalog_model->getCatalog();
        $this->render_page('catalog/index', $data);
    }

    public function insert(){
  		$product_id = $this->input->post('product_id');
  		$product_title = $this->input->post('product_title');
  		$price = $this->input->post('price');

      for($i=0; $i < sizeof($product_id); $i++){
        $batch = 1;
        $data = array(
          'product_id' => $product_id[$i],
          'product_title' => $product_title[$i],
          'price' => $price[$i],
          'batch' => "batch" + $batch[$i],
         );

        $query = $this->catalog_model->insertuser($data);
      }

  		return redirect('asset/index');
  	}
}
