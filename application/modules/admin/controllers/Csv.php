<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Csv extends App_Controller
{
    
    public $oldname;

    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("csv_model");
        //$this->admins_only();
        
    }

    public function index(){
        
        $this->load->model("mapper_model");
        
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        
        
        $this->form_validation->set_rules('csv', 'Import file', 'trim');        
        if ($this->form_validation->run() == true){ 
            $data = array();          
            if($_FILES['csv']['error'] == 0){
                $name    = $_FILES['csv']['name'];
                $ext     = strtolower(end(explode('.', $_FILES['csv']['name'])));
                $type    = $_FILES['csv']['type'];
                $tmpName = $_FILES['csv']['tmp_name'];
                if($ext === 'csv'){
                    $data    = array_map('str_getcsv', file($tmpName));               
                    $message = $this->mapper_model->import_products($data);
                    
                    $this->load->model('products_model');
                    $this->products_model->set_featured_image();
                    
                    $this->session->set_flashdata('app_success', $message);
                    redirect('admin/csv');
                }
                else{
                    $this->session->set_flashdata('app_error', 'Sorry! Only csv files are allowed');
                    redirect('admin/csv');
                }
            }
            else{
                $this->session->set_flashdata('app_error', 'Sorry! Only csv files are allowed');
                redirect('admin/csv');
            }
        }
        $this->render_page('csv/index', array('current' => 'point', 'subs' => 'csv') );
    }
    
    
    function download(){
        $this->load->model('mapper_model');
        
        $products = $this->mapper_model->get_products_download();
        
        // file name 
        $filename = 'products_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array("DESCRIPT","CODE","ONHAND", "SELLPINC1", "Weight", "L", "W", "H", "DESCRIPT", "DEPARTMENT", "Category", "Type"); 
        fputcsv($file, $header);
        
        foreach ($products as $product){            
            
            list($type, $department, $category) = explode("||", $product->c_name);
                      
            fputcsv($file,array($product->short_name, $product->code, $product->stock, $product->price, $product->weight, $product->length, $product->width, $product->height, $product->short_name, $department, $category, $type )); 
            
        }
        
        fclose($file); 
        exit; 
  
    }
}    