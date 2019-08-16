<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class to deal with all product related details
 */

class Products extends App_Controller
{
    
    public $oldsku;
    public function __construct()
    {
        parent::__construct();
        $this->load->library("lib_log");
        $this->load->model("products_model");
        $this->admins_only();
    }

    public function index(){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        $this->render_page('products/index', array( 'products' => array() ));
    }
    
    public function load_products()
    {
        $start  = $this->input->post("start");
        $length = $this->input->post("length");
        $search = $this->input->post("search");
        $this->session->set_userdata('datatable_start', $start);
        $this->session->set_userdata('datatable_length', $length);
        $this->session->set_userdata('datatable_search', $search['value']);
        
        $this -> load -> library('Datatable', array('model' => 'order_dt', 'rowIdCol' => 'p.id'));
	   $jsonArray = $this -> datatable -> datatableJson(array(
            'status' => 'boolean',
            'date'   => 'date',
            'price'  => 'currency',
            'id'     => 'edit',
            'image'  => 'image',
            'model'  => 'model'
        ));      
        $this -> output -> set_header("Pragma: no-cache");
        $this -> output -> set_header("Cache-Control: no-store, no-cache");
        $this -> output -> set_content_type('application/json') -> set_output(json_encode($jsonArray));
    }
    
    public function create()
    {
        $title               = 'Create';
        $this->oldsku        = '';
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'awsome_checkbox.css' );  
        $this->assets_js     = array( 'ckeditor.js', 'parsely-remote.min.js' );
        $this->form_validation->set_rules('shortname', 'Product short name', 'trim|required|min_length[3]|max_length[45]');
        if ($this->form_validation->run() == true)
        { 
            $insert_id = $this->products_model->new_create();
            if( is_numeric($insert_id)){
                redirect('admin/products/new_product/'.$insert_id);
            }
            else{
                showFlash('Sorry! Unable to '.strtolower($title).' product', 'danger');
                redirect( 'admin/products/create');
            }  
        }
        else
        {     
            $data = array(
                        "head_title"                        => $title,
                        "shortname"  => array(
                            'name'                          => 'shortname',
                            'type'                          => 'text',
                            'value'                         => isset($product->short_name) ? $product->short_name : $this->form_validation->set_value('shortname'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product short name:( Max 40 chars )',
                            'data-parsley-length'           => '[3, 45]',
                            'required'                      => '',
                        )
                    );
        }
        $this->render_page('products/create', $data );
    }
    
    public function new_product($id = ''){
        $title                  = 'Create';
        $this->oldsku           = '';
        $duplicate_check        = '|is_unique[products.sku]';
        if (!empty($id)){
            $product = $this->products_model->get_products($id, 'id'); 
            if (!$product)
                show_404 ();
            $title               = 'Update';
            $duplicate_check = '';
            
        }
        $pass = !empty($id) ? $id : 0;

        $this->page_title       = 'Admin';
        $this->assets_css       = array( 'awsome_checkbox.css' );  
        $this->assets_js        = array( 'ckeditor.js', 'parsely-remote.min.js' );
          
        $this->form_validation->set_rules('shortname', 'Product short name', 'trim|required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('longname', 'Product long name', 'trim|required|min_length[3]|max_length[70]');
        
        $this->form_validation->set_rules('sku', 'SKU', 'trim|min_length[3]|required|max_length[200]'.$duplicate_check);
        
        $this->form_validation->set_rules('model', 'Product model', 'trim');
        $this->form_validation->set_rules('description', 'Product description', 'trim|min_length[3]');
        $this->form_validation->set_rules('strike_price', 'Strike price', 'trim|numeric');
        $this->form_validation->set_rules('featured', 'Product featured', 'trim|integer');
        $this->form_validation->set_rules('status', 'Product status', 'trim|integer');
        $this->form_validation->set_rules('id', 'Product featured', 'trim|integer');
        $this->form_validation->set_rules('weight', 'Product weight', 'trim|required|numeric');
        $this->form_validation->set_rules('height', 'Product hight', 'trim|required|numeric');
        $this->form_validation->set_rules('length', 'Product length', 'trim|required|numeric');
        $this->form_validation->set_rules('width', 'Product width', 'trim|required|numeric');
        $this->form_validation->set_rules('price', 'Product price', 'trim|required|numeric');
        $this->form_validation->set_rules('envelop', 'Envelop type', 'trim|integer');
        $this->form_validation->set_rules('page_title', 'Page title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Product description', 'trim');
        
        $formSubmit = $this->input->post('submitForm');
        $redirect   = $this->input->post('redirect');
        
        if ($this->form_validation->run() == true){ 
            $result = $this->products_model->create_new();
            if( $result){
                if($redirect)
                    redirect ($redirect);
                                
                showFlash('New product '.strtolower($title).'d successfully!' );
                if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/new_product/'.$result); 
            }
            else{
                showFlash('Sorry! Unable to '.strtolower($title).' product', 'danger');
                redirect('admin/products/new_product');
            } 
        }
        else{          
            include APPPATH . 'third_party/collivery_client/src/Mds/Collivery.php';
            $parcel         = array();
            if($this->config->item('collivery_config')){
                
                $collivery      = new Collivery( $this->config->item('collivery_config') );
                $parcel_types   = $collivery->getParcelTypes();
                foreach ($parcel_types as $key => $types){
                    $parcel[$key] = $types['type_text'].' - '.$types['type_description'];
                }
            }
            $data = array(
                        "product"                           => $product,
                        "head_title"                        => $title,
                        "parcel_types"                      => $parcel,
                        "envelop"                           => isset($product->envelop_type) ? $product->envelop_type : $this->form_validation->set_value('envelop'),
                        "shortname"  => array(
                            'name'                          => 'shortname',
                            'type'                          => 'text',
                            'value'                         => isset($product->short_name) ? $product->short_name : $this->form_validation->set_value('shortname'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product short name:( Max 20 chars )',
                            'data-parsley-length'           => '[3, 45]',
                            'required'                      => '',
                        ),
                        "longname"  => array(
                            'name'                          => 'longname',
                            'type'                          => 'text',
                            'value'                         => isset($product->	long_name) ? $product->	long_name : $this->form_validation->set_value('longname'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product long name:( Max 70 chars )',
                            'data-parsley-length'           => '[3, 70]',
                            'required'                      => '',
                        ),
                        "sku"  => array(
                            'name'                          => 'sku',
                            'type'                          => 'text',
                            'value'                         => isset($product->sku) ? $product->sku : $this->form_validation->set_value('sku'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product sku:( Unique )',
                            'data-parsley-length'           => '[3, 200]',
                        ),
                        "model"  => array(
                            'name'                          => 'model',
                            'type'                          => 'text',
                            'value'                         => isset($product->model) ? $product->model : $this->form_validation->set_value('model'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product model name:( Max 20 chars )',
                            'data-parsley-length'           => '[3, 20]',
                        ),
                        "description"  => array(
                            'name'        => 'description',
                            'id'          => 'description',
                            'value'       => isset($product->long_description) ? $product->long_description : $this->form_validation->set_value('description'),
                            'rows'        => '5',
                            'cols'        => '10'
                        ),
                        "price"  => array(
                            'name'                          => 'price',
                            'type'                          => 'text',
                            'value'                         => isset($product->price) ? $product->price : $this->form_validation->set_value('price'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product price:',
                            'required'                      => '',
                            'data-parsley-type'             => 'number' 
                        ),
                        "strike_price"  => array(
                            'name'                          => 'strike_price',
                            'type'                          => 'text',
                            'value'                         => isset($product->strike_price) ? $product->strike_price : $this->form_validation->set_value('strike_price'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product strike price:',
                            'required'                      => '',
                            'data-parsley-type'             => 'number' 
                        ),
                        "weight"  => array(
                            'name'                          => 'weight',
                            'type'                          => 'text',
                            'value'                         => isset($product->weight) ? $product->weight : $this->form_validation->set_value('weight'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product weight in kg:',
                            'required'                      => '',
                            'data-parsley-type'             => 'number' 
                        ),
                
                        "height"  => array(
                            'name'                          => 'height',
                            'type'                          => 'text',
                            'value'                         => isset($product->height) ? $product->height : $this->form_validation->set_value('height'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product height in cm:',
                            'required'                      => '',
                            'data-parsley-type'             => 'number' 
                        ),
                        "length"  => array(
                            'name'                          => 'length',
                            'type'                          => 'text',
                            'value'                         => isset($product->length) ? $product->length : $this->form_validation->set_value('length'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product height in cm:',
                            'required'                      => '',
                            'data-parsley-type'             => 'number' 
                        ),
                        "width"  => array(
                            'name'                          => 'width',
                            'type'                          => 'text',
                            'value'                         => isset($product->width) ? $product->width : $this->form_validation->set_value('width'),
                            'class'                         => 'form-control',
                            'placeholder'                   => 'Product height in cm:',
                            'required'                      => '',
                            'data-parsley-type'             => 'number' 
                        ),
                        "featured"                          =>  isset($product->featured) ? $product->featured : $this->form_validation->set_value('featured'),
                        "status"                            => isset($product->status) ? $product->status : $this->form_validation->set_value('status'),
                        "strike_status"                     => isset($product->strike_status) ? $product->strike_status : $this->form_validation->set_value('strike_status'),
                        "id"                                => array(
                            'id'  => $id,
                        ),
                        'product_id'    => $id,
                        'groups'        => array()
                    );
        }
        $this->render_page('products/new_product', $data );
    }
    
    public function inventory($id=NULL){
        $title                  = 'Inventory';
        $this->oldsku           = '';
        if (!empty($id)){
            $product = $this->products_model->get_products($id, 'id'); 
            if (!$product)
                show_404 ();
        }
        $this->page_title       = 'Admin';
        $this->assets_css       = array( 'awsome_checkbox.css' );  
        $this->assets_js        = array( 'ckeditor.js', 'parsely-remote.min.js' );
          
        $this->form_validation->set_rules('inventory', 'Inventory option', 'trim|required|numeric');
        
        if($this->input->post('inventory') == 2){
            $this->form_validation->set_rules('stock', 'Stock', 'trim|required|numeric');
            $this->form_validation->set_rules('stock_min', 'Stock min', 'trim|required|numeric');
        }
        $formSubmit             = $this->input->post('submitForm');
        $redirect               = $this->input->post('redirect');
        
        if ($this->form_validation->run() == true){ 
            $result = $this->products_model->update_inventory($id);
            if( $result){
                if($redirect)
                    redirect ($redirect);
                                
                showFlash('New product '.strtolower($title).'d successfully!' );
                if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/inventory/'.$result); 
            }
            else{
                showFlash('Sorry! Unable to '.strtolower($title).' product', 'danger');
                redirect('admin/products/inventory/'.isset($id) ? $id : '');
            }
        }
        else{          
            $data['inventory']  = $product->inventory ? $product->inventory : 1;
            $data['stock']      = $product->stock;
            $data['stock_min']  = $product->stock_min ? $product->stock_min : 0;
            $data['product_id'] = $id; 
            $data['id']         = $id;
            $this->render_page('products/inventory', $data);
        }
    }

    public function deactivate($product_id){
        if(!is_numeric($product_id)){
            redirect('admin/products');die;
        }
        
        $result = $this->products_model->deactivate($product_id);
        if($result){
            showFlash('Product deactivated.' );
            redirect('admin/products'); die;
        }
        
        showFlash('Sorry! Unable to deactivate product', 'danger');
        redirect('admin/products');die;
        
    }
    
    public function activate($product_id)
    {
        if(!is_numeric($product_id)){
            redirect('admin/products');die;
        }
        $result = $this->products_model->activate($product_id);
        if($result){
            showFlash('Product activated.' );
            redirect('admin/products'); die;
        }
        showFlash('Sorry! Unable to activate product', 'danger');
        redirect('admin/products');die; 
    }
    
    public function manufacture($id = '')
    {
        if (empty($id))
            show_404 ();
        $products = $this->products_model->get_product_manus($id);
        if (!$products)
            show_404 ();
        
        $title               = 'Update';
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array(); 
        
        $manus      = $this->products_model->get_manus();
        $formSubmit = $this->input->post('submitForm');
        $redirect   = $this->input->post('redirect');
        if($redirect)
            $this->form_validation->set_rules('manu', 'Manufacturer', 'trim|integer');
        else    
            $this->form_validation->set_rules('manu', 'Manufacturer', 'trim|integer|required');
        
        if ($this->form_validation->run() == true)
        { 
            $result = FALSE;
            if($this->input->post('manu'))
                $result = $this->products_model->add_manus($id);
            
            if( $result)
            {
               showFlash('Manufacture '.strtolower($title).'d successfully!' );
               if($redirect)
                   redirect ($redirect);
               
               if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/manufacture/'.$id);  
            }
            else
            {
                if($redirect)
                   redirect ($redirect);
                showFlash('Sorry! Unable to '.strtolower($title).' manufacturer!', 'danger');
                redirect('admin/products/manufacture/'.$id);
            }
        }
        else
        {     
            $product = $products;
            $data    = array(
                'products'         => $products,
                'manufactures'    => $manus,
                'head_title'      => $title,
                'id'              => $id,
                'product_id'      => $id,
            );
            $this->render_page('products/manufacture', $data );
        }     
    }
    
    
    public function categories($id = '')
    {
        if (empty($id))
            show_404 ();
        
        $products            = $this->products_model->get_product_cats($id);
        if (!$products)
            show_404 ();

        $title               = 'Update';
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array(); 
        
        $categories = $this->products_model->category_select();        
        $this->form_validation->set_rules('cats[]', 'Category', 'trim');
        $redirect   = $this->input->post('redirect');
        $formSubmit = $this->input->post('submitForm');
        if ($this->form_validation->run() == true)
        { 
            $result = $this->products_model->add_category($id);
            if( $result){
               showFlash('Categories '.strtolower($title).'d successfully!' );
               if($redirect)
                   redirect ($redirect);
               if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/categories/'.$id); 
            }
            else{
                showFlash('Please select a category.', 'danger');
                redirect('admin/products/categories/'.$id);
            }
        }
        else
        {     
            $existing_categories = array();
            foreach ($products as $pro){
                if (count($existing_categories) == 0){
                    $product = $pro;
                }
                $existing_categories[] = $pro->category_id;
            }
            $list = array();
            
            $data   = array(
                'product'       => $product,
                'categories'    => $categories,
                'head_title'    => $title,
                'id'            => $id,
                'product_id'    => $id,
                'existing_categories' => $existing_categories
            );
            $this->render_page('products/categories', $data );
        }    
    }
    
    
    public function images($id)
    {
        if (empty($id))
            show_404 ();
        
        $this->products_model->set_featured_image();
        $products = $this->products_model->products_images($id);
        if (!$products)
            show_404 ();

        $product = $products[0];
        $title               = 'Update';
        $this->page_title    = 'Admin';
        $this->assets_css    = array();  
        $this->assets_js     = array( 'parsely-remote.min.js' );  
          
        $this->form_validation->set_rules('images[]', 'Images', 'trim');
        $redirect            = $this->input->post('redirect');
        $formSubmit          = $this->input->post('submitForm');
        if ($this->form_validation->run() == true){ 
            $result = uploadMultiFiles($_FILES['images'], '/assets/products/img/original');
            $images               = array();
            foreach ($result as $key => $upload_result) {
                if($upload_result['status']){
                    $images[$key] = $upload_result['data']['file_name'];
                    resizeImages($upload_result['data']['full_path']);
                }
            }
            if(count($images) > 0){
                $result = $this->products_model->add_images($id, $images);
                $this->products_model->add_image_attributes($id);
                if($redirect){
                    redirect ($redirect);
                    die;
                }
                showFlash('Images '.strtolower($title).'d successfully!' );
                if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/images/'.$id); 
            }
            else{ 
                $this->products_model->add_image_attributes($id);
                if($redirect){
                    redirect ($redirect);
                    die;   
                }
                
                showFlash('Images '.strtolower($title).'d successfully!' );
                if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/images/'.$id); 
            } 
        }
        else{     
            
            $attribute_images  = $this->products_model->product_attribute_images($id);
            
            $attributes = $this->products_model->load_product_attributes($id);
            $data   = array(
                'product'           => $product,
                'head_title'        => $title,
                'id'                => $id,
                'products'          => $products,
                'product_id'        => $id,
                'attributes'        => $attributes,
                'attribute_images'  => $attribute_images
                   
            );
            
            $this->render_page('products/images', $data );
        }    
    }
    
  
    public function attributes($product_id)
    {   
        if(empty($product_id))
            show_404 ();
        
        $product = $this->products_model->get_products($product_id, 'id'); 
        if(!$product)
            show_404 ();
        
        
        $title               = 'Update';
        $this->page_title    = 'Admin';
        $this->assets_css    = array('dataTables.bootstrap.css', 'jquery-ui.css', 'custom.css');  
        $this->assets_js     = array( 'parsely-remote.min.js', 'jquery.dataTables.js', 'dataTables.bootstrap.js', 'jquery-ui.min.js');  
        
        
        $redirect   = $this->input->post('redirect');
        $formSubmit = $this->input->post('submitForm');
        
        $this->form_validation->set_rules('attribute_group', 'Attribute group', 'trim|required|integer');
        if ($this->form_validation->run() == true){ 
            $result = $this->products_model->update_product_option_group($product_id);
            
            if($redirect){
                redirect ($redirect);
                die; 
            }
            
            showFlash('Attribute options updated!' );
            if($formSubmit == 'formSaveClose')
                redirect('admin/products/'); 
            else
                redirect('admin/products/attributes/'.$product_id ); 
        }
        $option_groups   = $this->products_model->get_option_groups();
        $existing_groups = $this->products_model->get_product_action($product_id);
        $data           =   array(
            'groups'        => $option_groups,
            'product_id'    => $product_id,
            'id'            => $product_id,
            'existing_group'=> $existing_groups,
            'inventory'     => isset($product->inventory) ? $product->inventory : 1
        );
        $this->render_page('products/attributes', $data );
    }

    public function edit_attr($product_id, $pa_id)
    {        
        if(empty($product_id) || empty($pa_id))
            show_404 ();
        
        $product_attr = $this->products_model->get_product_attributes_by_paid($product_id, $pa_id);  
        if (!$product_attr)
            show_404 ();
        
        $attributes   = $this->products_model->get_attributes();
        
        $this->form_validation->set_rules('attribute', 'Attribute', 'trim|required|integer');
        $this->form_validation->set_rules('value', 'Attribute value', 'trim|required');
        $this->form_validation->set_rules('sort', 'Sort', 'trim|integer');

        if ($this->form_validation->run() == true)
        { 
            $result = $this->products_model->update_attributes($product_id, $pa_id);
            $result ? showFlash('Stock price updated successfully!' ): showFlash('Sorry! Unable to update stock price', 'danger');
            redirect('admin/products/attributes/'.$product_id);
        }
        else {
            $this->page_title    = 'Admin';
            $this->assets_css    = array();  
            $this->assets_js     = array( 'parsely-remote.min.js' );  
            

            $data   = array(
                'product'       => $product_attr,
                'attributes'    => $attributes,
                'id'            => $product_id,
                'head_title'    => $title,
                'paid'          => $pa_id,
            );
             $this->render_page('products/edit_attr', $data );
        }  
    }

    
    public function edit_stock($product_id, $stock_id)
    {        
        
        if(empty($product_id) || empty($stock_id))
            show_404 ();
        
        $product_attr = $this->products_model->get_product_stocks_by_paid($product_id, $stock_id);  
        if (!$product_attr)
            show_404 ();
        
        
        $this->form_validation->set_rules('price_variation', 'Price variation', 'trim|numeric|required');
        $this->form_validation->set_rules('total_stock', 'Total stock', 'trim|integer|required');
        $this->form_validation->set_rules('attribute1', 'Total stock', 'trim|required');
        
        if ($this->form_validation->run() == true)
        { 
            $result = $this->products_model->update_stocks($product_id, $stock_id);
            $result ? showFlash('Attributes '.strtolower($title).'d successfully!' ) : showFlash('Sorry! Unable to '.strtolower($title).' attributes', 'danger');
            redirect('admin/products/stocks/'.$product_id);
        }
        else {
            $this->page_title    = 'Admin';
            $this->assets_css    = array();  
            $this->assets_js     = array( 'parsely-remote.min.js' );  
            $attributes          = $this->products_model->get_product_attributes($product_id);
            $data   = array(
                'product'       => $product_attr,
                'attributes'    => $attributes,
                'id'            => $product_id,
                'head_title'    => $title,
                'all'           => $product_attr
            );
            $this->render_page('products/edit_stock', $data );
        }  
    }    
    
    public function bulk($product_id){
        if (empty($product_id) || !is_numeric($product_id))
            show_404 ();       
        $title               = 'Update';
        $this->page_title    = 'Admin';
        $this->assets_css    = array('dataTables.bootstrap.css', 'jquery-ui.css', 'custom.css');  
        $this->assets_js     = array( 'parsely-remote.min.js', 'jquery.dataTables.js', 'dataTables.bootstrap.js', 'jquery-ui.min.js');  
        
        
        $product             = $this->products_model->get_product_by_id($product_id);
        if (!$product)
            show_404 ();
        $this->form_validation->set_rules('from', 'From', 'trim');
        if ($this->form_validation->run() == true){
            $formSubmit = $this->input->post('submitForm');
            $redirect   = $this->input->post('redirect');
            $this->products_model->update_bulk_pricing($product_id);
            showFlash('Bulk pricing modified successfully!' );
            
            if($redirect)
                redirect ($redirect);
            
            if($formSubmit == 'formSaveClose')
                redirect('admin/products'); 
            else
                redirect('admin/products/bulk/'.$product_id ); 
        }
        $discounts = $this->products_model->discount_data($product_id);
        $data = array(
            'product_id' => $product_id,
            'discounts'  => $discounts
        );
        $this->render_page('products/bulk', $data );
    }

    public function stocks($product_id)
    {
        if (empty($product_id) || !is_numeric($product_id))
            show_404 ();
        
        $title               = 'Update';
        $product_attributes  = $this->products_model->price_stock_attributes($product_id);
        $product             = $this->products_model->get_product_by_id($product_id);
        
        if (!$product)
            show_404 ();
        
        $redirect   = $this->input->post('redirect');
        
        if($redirect){
            $this->form_validation->set_rules('price_variation', 'Price variation', 'trim|numeric');
            $this->form_validation->set_rules('total_stock', 'Total stock', 'trim|integer');
            $this->form_validation->set_rules('attribute1', 'Total stock', 'trim');
            
        }
        else{
            $this->form_validation->set_rules('price_variation', 'Price variation', 'trim|integer|required');
            $this->form_validation->set_rules('total_stock', 'Total stock', 'trim|integer|required');
            $this->form_validation->set_rules('attribute1', 'Total stock', 'trim|required');
        }
        
        $formSubmit = $this->input->post('submitForm');
        if ($this->form_validation->run() == true)
        { 
            
            if($redirect && ( $this->input->post('price_variation') == "" || $this->input->post("attribute1") == "" || $this->input->post("total_stock") == "") )
            {
                redirect ($redirect);
                die;
            }
            $result = $this->products_model->create_stock_price($product_id);
            
            if( $result)
            {
                
                if($redirect)
                    redirect ($redirect);
                
                showFlash('Attributes '.strtolower($title).'d successfully!' );
                
                if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/stocks/'.$product_id); 
            }
            else
            {
                showFlash('Sorry! Unable to '.strtolower($title).' attributes', 'danger');
                redirect('admin/products/stocks/'.$product_id);
            }
        }
        else{
            $this->page_title    = 'Admin';
            $this->assets_css    = array('dataTables.bootstrap.css');  
            $this->assets_js     = array('parsely-remote.min.js', 'jquery.dataTables.js', 'dataTables.bootstrap.js');
            
            //Select all attributes
            $attributes          = $this->products_model->get_product_attributes($product_id);
            
            $message = '';
            if ( !isset($attributes[0]->at_id) || is_null($attributes[0]->at_id) )
            {
                
                showFlash('Please select an attribute before allocating stock.', 'danger');
                redirect('admin/products/attributes/'.$product_id);
                die;
                $message = 'You didnt added any product attribute in the previous step.<br/><br/> '
                        . 'You must set atleast simple product attribute to set stock in this tab <br/><br/>'
                        . 'Click <a href="'.  site_url("admin/products/attributes/$product_id").'">here</a> to go back';
            }
            
            
            $data   = array(
                'product'       => $product,
                'attributes'    => $attributes,
                'id'            => $product_id,
                'head_title'    => $title,
                'all'           => $product_attributes,
                'message'       => $message,
                'product_id'    => $product_id,
            );
            
            $this->render_page('products/stocks', $data );
        }
    }
    
    public function settings($product_id) 
    {
        if (!is_numeric($product_id))
            show_404 ();
        
        $title = 'Update';
        
        $products     = $this->products_model->get_products($product_id, 'p.id');
        
        if(!$products)
            show_404 ();
        
        $checked = $this->input->post('offer');
        $new     = $this->input->post('new');
        
        $this->form_validation->set_rules('offer', 'Offer', 'trim');
        $this->form_validation->set_rules('new', 'New', 'trim');
       // $this->form_validation->set_rules('status', 'Visible', 'trim');
        
        if ($checked)
        {
            $this->form_validation->set_rules('offer_value', 'Offer value', 'trim|integer|required');
            $this->form_validation->set_rules('offer_from', 'Offer from', 'trim|required|callback_validate_date');
            $this->form_validation->set_rules('offer_to', 'Offer to', 'trim|required|callback_validate_date');
        }  

        if ($new){
            $this->form_validation->set_rules('new_from', 'New from', 'trim|required|callback_validate_date');
            $this->form_validation->set_rules('new_to', 'New to', 'trim|required|callback_validate_date');
        }
        
        $redirect   = $this->input->post('redirect');
        $formSubmit = $this->input->post('submitForm');
        if ($this->form_validation->run() == true)
        { 
            
            $result = $this->products_model->create_offers($product_id);
            
            if( $result)
            {
                if($redirect)
                    redirect ($redirect);
                
                showFlash('Settings '.strtolower($title).'d successfully!' );
                
                if($formSubmit == 'formSaveClose')
                    redirect('admin/products'); 
                else
                    redirect('admin/products/settings/'.$product_id); 
            }
            else
            {
                showFlash('Sorry! Unable to '.strtolower($title).' settings', 'danger');
                redirect('admin/products/settings/'.$product_id);
            }
        }
        else{
            $this->page_title    = 'Admin';
            $this->assets_css    = array('jquery-ui.css');  
            $this->assets_js     = array('parsely-remote.min.js', 'jquery-ui.min.js');
            
            //Select all attributes
            $system_attrv        = $this->products_model->select_offer_attributes($product_id);   
            $product             = $products;        

            $offer = array();
            if ($system_attrv)
            {
             
                foreach ($system_attrv as $exist)
                {
                    $offer[$exist->index] = $exist->value;
                }
            }
            $data = array(
                                
                        'offer' => array(
                            'name'        => 'offer',
                            'id'          => 'offer',
                            'value'       => 1,
                            'checked'     => isset($offer['offer']) ? $offer['offer'] : $this->form_validation->set_value('offer'),
                            'style'       => 'margin:10px',
                        ),
                        'new' => array(
                            'name'        => 'new',
                            'id'          => 'new',
                            'value'       => 1,
                            'checked'     => isset($offer['new']) ? $offer['new'] : $this->form_validation->set_value('new'),
                            'style'       => 'margin:10px',
                        ),
                        'status' => array(
                            'name'        => 'status',
                            'id'          => 'status',
                            'value'       => 1,
                            'checked'     => isset($product->status) ? $product->status : $this->form_validation->set_value('status'),
                            'style'       => 'margin:10px',
                        ),
                        'offer_value' => array(
                            'name'        => 'offer_value',
                            'placeholder' => 'Offer value(In percentage)',
                            'value'       => isset($offer['offer_value']) ? $offer['offer_value'] : $this->form_validation->set_value('offer_value'),  
                            'class'       => 'form-control'
                        ),
                        'offer_from' => array(
                            'name'        => 'offer_from',
                            'placeholder' => 'Offer start date',
                            'value'       => isset( $offer['offer_from']) ?  $offer['offer_from'] : $this->form_validation->set_value('offer_from'),  
                            'class'       => 'form-control datepicker'
                        ),
                        'offer_to' => array(
                            'name'        => 'offer_to',
                            'placeholder' => 'Offer end date',
                            'value'       => isset($offer['offer_to']) ?  $offer['offer_to'] : $this->form_validation->set_value('offer_to'),  
                            'class'       => 'form-control datepicker'
                        ),
                        'new_from' => array(
                            'name'        => 'new_from',
                            'placeholder' => 'Set product new from date',
                            'value'       => isset( $offer['new_from']) ?  $offer['new_from'] : $this->form_validation->set_value('new_from'),  
                            'class'       => 'form-control datepicker'
                        ),
                        'new_to' => array(
                            'name'        => 'new_to',
                            'placeholder' => 'Set product new to date',
                            'value'       => isset( $offer['new_to']) ?  $offer['new_to'] : $this->form_validation->set_value('new_to'),  
                            'class'       => 'form-control datepicker'
                        ),
                        'product'       => $product,
                        'id'            => $product_id,
                        'head_title'    => $title,
                        'product_id'    => $product_id,
                    );
            
 
            
            $this->render_page('products/settings', $data );
        }
    }

    public function group_attributes(){
        $group_id = $this->input->post('attribute_group');
        $product_id = $this->input->post('product_id');
        if(empty($group_id) || !is_numeric($group_id) || (empty($product_id) || !is_numeric($product_id)) ){
            $html_text = '<span class="alert alert-danger">No attributes found.</span>';
        }
        else{
            $this->products_model->update_product_option_group($product_id);
            $attributes = $this->products_model->get_grouped_attributes($group_id);
            $html_text  = '<ul class="attribute_list">';
            foreach ($attributes as $attribute){
                if(empty($attribute->name))
                    continue;
                $html_text .= '<li data-id="'.$attribute->id.'">'.$attribute->name.'</li>';
            }
            $html_text  .= '</ul>';
        }
        echo $html_text;
        die;
    }

    

    private function do_resize($filename, $folder='thumb', $width=400, $height=243,$src_width=1, $src_height=0)
    { 
        //$filename = $this->input->post('new_val');
        $source_path = IMAGE_PATH.$filename;
        $type        = exif_imagetype($source_path);
        $file_name   = basename($source_path);
        $target_path = IMAGE_PATH.$folder.SP; 
        
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'create_thumb' => TRUE,
            'thumb_marker' => '',
            'width' => $width,
            'height' => $height,
            'master_dim' => $src_width >= $src_height ? 'width' : 'height'
        ); 
        $this->load->library('image_lib');
        // Set your config up
        $this->image_lib->initialize($config_manip);
        $uploaded = $this->image_lib->resize();
                
        if (!$uploaded) {
            echo $this->image_lib->display_errors();
        }
        // clear //
        $this->image_lib->clear();
        
        $this->fill_image(base_url('assets/images/products/'.$folder.SP.$file_name), $target_path, $width, $width, $type);
        return;
    }
    
    
    public function fill_image($url, $target, $width, $height, $type){ 
        
        if($type == 1)
            $src = imagecreatefromgif($url);
        
        else if($type == 2)
            $src = imagecreatefromjpeg($url);
        
        else if($type == 3)
            $src = imagecreatefrompng($url);
        
        else
            return;

        
        //$src_wide = imagesx($src);
        //$src_high = imagesy($src);
        list($src_wide, $src_high) = getimagesize($url);

        // set white padding color
        $clear = array('red'=>255,'green'=>255,'blue'=>255);
        // new image dimensions with right padding
        
        if($src_wide > $src_high){
            $dst_wide = $src_wide;
            $dst_high = $height-$src_high;
        }
        if($src_wide < $src_high){
            $dst_high = $src_high;
            $dst_wide = $width-$src_width;
        }
        
        if($dst_high <= 0 || $dst_wide <= 0)
            return;
        
        //$dst = imagecreatetruecolor($dst_wide, $dst_high);
        
        $dst = imagecreatetruecolor($width, $height);
        $clear = imagecolorallocate( $dst, $clear["red"], $clear["green"], $clear["blue"]);
        
        imagefill($dst, 0, 0, $clear);
        //$top = round(($dst_high-$src_high)/2);
        
        if($src_wide > $src_high){
            $top = round(($height-$src_high)/2);
            imagecopymerge($dst,$src,0,$top,0,0,$src_wide,$src_high, 100);
        }
        if($src_wide < $src_high){
            $side = round(($width-$src_wide)/2);
            imagecopymerge($dst,$src,$side,0,0,0,$src_wide,$src_high, 100);
        }
        
        $target .= basename($url);
        if($type == 1)
            $re = imagegif($dst, $target, 100);
        
        else if($type == 2){
            $re = imagejpeg($dst, $target, 100);            
        }
        else if($type == 3){
            imagesavealpha($dst, true);
            imagepng($dst,$target,0);
        
        }
        else
            return;
        
        
        
        imagedestroy($src);
        imagedestroy($dst);
    }

    private function upload_files($files, $path = IMAGE_PATH, $title = '')
    {        
        $config = array(
            'upload_path'   => IMAGE_PATH,
            'allowed_types' => '*',
            'overwrite'     => 1,                       
        );

        $this->load->library('upload', $config);
        $images = array();

        foreach ($files['name'] as $key => $image) {            
        
            if (!empty($image))
            {    
                $_FILES['images[]']['name']= $files['name'][$key];
                $_FILES['images[]']['type']= $files['type'][$key];
                $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
                $_FILES['images[]']['error']= $files['error'][$key];
                $_FILES['images[]']['size']= $files['size'][$key];

                list($src_width, $src_height) = getimagesize($files['tmp_name'][$key]);        
        
        
                $fileName = $title .'_'.preg_replace('/\s+/', '_', $image);
                $images[$key] = $fileName;
                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('images[]')) {
                    $this->upload->data();
                   
                    $this->do_resize($fileName, 'thumb', 400, 243, $src_width, $src_height);
                    $this->do_resize($fileName, 'thumb/350X350', 350, 350, $src_width, $src_height);
                    $this->do_resize($fileName, 'thumb/520X520', 520, 520, $src_width, $src_height);
                    $this->do_resize($fileName, 'thumb/900X900', 900, 900, $src_width, $src_height);
                }
                else{
                    $error = array('error' => $this->upload->display_errors());   
                    die(implode(', ', $error));           
                }
                
            }    
        }

        
        return count($images) > 0 ? $images : FALSE;
    }
    
    
    public function delete_image($product_id, $image_id)
    {
        if (empty($product_id) || empty($image_id))
            show_404 ();
        
        if (!is_numeric($product_id) || !is_numeric($image_id))
            show_404 ();
        
        $result = $this->products_model->remove_product_image($product_id, $image_id);
        $result ? showFlash('Image removed successfully!' ) : showFlash('Sorry! Unable to delete image', 'danger');
        redirect('admin/products/images/'.$product_id);
    }

    public function delete_attribute($product_id, $attribute_id)
    { 
        if (!is_numeric($product_id) || !is_numeric($attribute_id))
            show_404 ();
        
        $result = $this->products_model->remove_attributes(array('product_id' => $product_id, 'id' => $attribute_id));
        
        $result ? showFlash('Attributes removed successfully!' ) : showFlash('Sorry! Unable to delete attributes', 'danger');
        redirect('admin/products/attributes/'.$product_id);
    }
    
    public function delete_stock($product_id, $stock_id){
        if (!is_numeric($product_id) || !is_numeric($stock_id))
            show_404 ();

        $result = $this->products_model->remove_stock_price_products(array('product_id' => $product_id, 'id' => $stock_id));
        
        $result ? showFlash('Attributes removed successfully!' ) : showFlash('Sorry! Unable to delete attributes', 'danger');
        redirect('admin/products/attributes/'.$product_id);
    }
    
    public function delete($product_id)
    {
        if (!is_numeric($product_id))
            show_404 ();
        
        $result = $this->products_model->remove_products($product_id);
        
        $result ?showFlash('Product removed successfully!' ) : showFlash('Sorry! Unable to delete product', 'danger');
        redirect('admin/products');
    }

    public function validate_stock_attributes($price)
    {
        $attr1   = $this->input->post('attribute1');
        $attr2   = $this->input->post('attribute2');
        $attr3   = $this->input->post('attribute3');
        $attr4   = $this->input->post('attribute4');
        $attr5   = $this->input->post('attribute5');
        
        $stocks  = $this->input->post('total_stock');
        $price   = $this->input->post('price_variation');
        
        foreach ($attr1 as $key => $attr)
        {
            if (!empty($attr) && !is_numeric($attr))
            {
                $this->form_validation->set_message('validate_stock_attributes', 'You have selected an invalid attribute 1');
                return FALSE;
            }
            if (!is_numeric($stocks[$key]))
            {
                $this->form_validation->set_message('validate_stock_attributes', 'If you set attribute 1, the stock must be a valid integer');
                return FALSE;
            } 

            if ( !is_numeric($price[$key]))
            {
                $this->form_validation->set_message('validate_stock_attributes', 'If you set attribute 1, the price must be a valid number ');
                return FALSE;
            }  
            
        }
        return TRUE;
    }
    
    function validate_date($date) {
        if (date('Y-m-d', strtotime($date)) == $date) {
            return TRUE;
        } else {
            $this->form_validation->set_message('validate_date', 'The %s date must be in format "yyyy-mm-dd');
                return FALSE;
        }
    }
    
    public function sku($product_id){
        $this->page_title    = 'Admin';
        $this->assets_css    = array( 'dataTables.bootstrap.css' );  
        $this->assets_js     = array( 'jquery.dataTables.js', 'dataTables.bootstrap.js' );  
        
        $this->template->set_layout('ajax');
        $stocks     = $this->products_model->get_attribute_stocks($product_id);
        $attributes = $this->products_model->get_attribute_options($product_id);        
        
        $this->render_page('products/sku', array('stocks' => $stocks, 'attributes' => $attributes, 'product_id' => $product_id) );
    }
    
    public function stock_price_update(){
        $stock_id = $this->input->post('stock_id');
        $result = $this->products_model->update_stock_options($stock_id);
        if($result)
            showFlash('SKU updated successfully!' );
        else
            showFlash('SKU already exist!', 'danger' );
        die;
    }
    
    public function get_stocks(){
        $product_id = $this->input->post('product_id');
        $stock_id   = $this->input->post('stock_id');
        
        if(!is_numeric($stock_id) || !is_numeric($product_id))
            die(json_encode (array('success' => 0, 'msg' => 'Invalid data provided!')));
        $stock      = $this->products_model->get_stocks($product_id, $stock_id);
        
        if(!$stock)
            die(json_encode (array('success' => 0, 'msg' => 'Invalid data provided here!')));
        
        die(json_encode(array('success' => 1, 'data' => $stock)));
    }
    
    public function _unique_sku($aname) {

        if (strtolower($aname) == strtolower($this->oldname)) 
        {
            return true;
        }

        if ($this->products_model->get_products_sku($aname, 'sku')) {

            $this->form_validation->set_message('_unique_name', 'The sku must be unique');

            return false;
        }

        return true;
    }
}