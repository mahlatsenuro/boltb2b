<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Products extends REST_Controller
{

    private $allowed_img_types;

    function __construct()
    {   
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['set_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['productDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Base_model');
    }

    function all_get($page=1, $search="", $category=null){

        $bModel             = $this->Base_model;     
        $limit              = $this->config->item("products_page_limit") ? 
                                $this->config->item("products_page_limit") : 6;  
        $bModel->where      = array('p.status' => 1);    
        $products_data      = $bModel->getAllProducts(
                                            $limit, $page, $search, $category);
        $products           = array();
        if($products_data){
            $products       = $products_data['products'];
            $attributeData  = $this->Base_model->getProductAttributes($products_data['product_ids']);

            if($attributeData){
                foreach ($products as $key => $product) {
                    if(isset($attributeData[$product->product_id])) { 
                        $product->attributes = $attributeData[$product->product_id];
                    }
                    $product->displayPrice = formatDisplayPrice($product->basePrice);
                }
            }  
        } 
        $this->response($products, REST_Controller::HTTP_OK);
    }    
    function one_get($productId){
        $bModel             = $this->Base_model;     
        $bModel->where      = array('p.status' => 1);    
        $product            = $bModel->getOneProduct($productId);
        if($product){
            $attributeData  = $this->Base_model->getProductAttributes($productId);
            if($attributeData){
                $product->attributes = $attributeData[$product->product_id];
            }  
            $this->response($product, REST_Controller::HTTP_OK);
        }  else {
            $this->response([
                'status' => FALSE,
                'message' => 'No products were found'
                    ], REST_Controller::HTTP_NOT_FOUND); 
        }
        
    }
    
    function categories_get(){
        $bModel             = $this->Base_model;
        $bModel->where      = array('c.active', 1);
        $categories         = $bModel->getAllCategories();
        if($categories)
            $this->response($categories, REST_Controller::HTTP_OK);

        else
            $this->response([
                'status' => FALSE,
                'message' => 'No categories were found'
                    ], REST_Controller::HTTP_NOT_FOUND); 
    }


    
}