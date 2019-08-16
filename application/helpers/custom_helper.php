<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @method price to display price in display format
 * @return price
 */
function getProductImage($image, $type='medium'){
    
    $url_parts  = explode('/', base_url());
    $productImagePath = '/'.implode('/', array_slice($url_parts, 3)).'assets/products/img/';

    if(file_exists(FCPATH.'../'.$productImagePath.$type.DIRECTORY_SEPARATOR.$image))
        return $productImagePath.$type.DIRECTORY_SEPARATOR.$image;
    else
        return $productImagePath.'original'.DIRECTORY_SEPARATOR.$image;
}

function displayPrice($price){
    $price = calculatePrice($price);
    return   "R".$price;
}

function calculatePrice($price){
    return $price;
}

function calculateDeliveryDate(){
    return 'Delivery in '.Date('M Y', strtotime("+7 day", time()));
}

function loadAsset($asset, $common=false){
    $template  = getTemplate(); 
    $url_parts = explode('/', base_url());
    
    if(!$common)
    	$cssPath   = '/'.implode('/', array_slice($url_parts, 3)).'assets/templates/'.$template.'/'.$asset; 
    else
    	$cssPath   = '/'.implode('/', array_slice($url_parts, 3)).'assets/common/'.$asset; 

    return $cssPath;
}

function getTemplate(){
	$CI         =& get_instance();
	$template   = strpos(current_url(), "/admin/") ? "admin/default" : 
											$CI->config->item("_template");

	return $template;
}

function formatNumber($number, $format=''){
    return $number ? number_format((float)$number, 2, '.', $format) : 0;
}

function formatDisplayPrice($number, $format=','){
    $price = $number ? number_format((float)$number, 2, '.', $format) : 0;
    return 'R'.$price;
}   

function formatDate($date = "", $timestamp=false){
    if (!empty($date)):
        return $timestamp ? date("jS  F Y h:i:s A", $date) : date("l jS \of F Y h:i:s A", strtotime($date));
    endif;
    return;
}

function showFlash($message, $type="success"){
    $CI         =& get_instance();
    $CI->session->set_flashdata("message", "<div class='alert alert-".$type."'>$message</div>");
    return;
}

function hash_new_password($password){
    if (empty($password)){
            return FALSE;
    }
    $salt = substr(md5(uniqid(rand(), true)), 0, 10);
    return  $salt . substr(sha1($salt . $password), 0, -10);
}

function fill_chunck($array, $parts) {
    $t = 0;
    $result = array_fill(0, $parts - 1, array());
    $max = ceil(count($array) / $parts);
    foreach($array as $v) {
        count($result[$t]) >= $max and $t ++;
        $result[$t][] = $v;
    }
    return $result;
}

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = strtolower($string);
    return preg_replace('/[^a-z0-9\-_]/', '', $string); // Removes special chars.
}

function buildCategory($parent, $category, $existing_categories) { 
    $html = "";
    if (isset($category['parent_cats'][$parent])) { 
        $html .= "<ul>\n";
        foreach ($category['parent_cats'][$parent] as $cat_id) { 
            if (!isset($category['parent_cats'][$cat_id])) { 
                $checked = in_array($category['categories'][$cat_id]['id'], $existing_categories) ? 'checked' : '';
                $html .= "<li>\n<input type='checkbox' name='cats[]' value='".$category['categories'][$cat_id]['id']."' $checked >&nbsp; " . $category['categories'][$cat_id]['name'] . "\n</li> \n";
            }
            if (isset($category['parent_cats'][$cat_id])) {
                $checked = in_array($category['categories'][$cat_id]['id'], $existing_categories) ? 'checked' : ''; 
                $html .= "<li>\n<input type='checkbox' name='cats[]' value='".$category['categories'][$cat_id]['id']."' $checked >&nbsp;  " . $category['categories'][$cat_id]['name'] . " \n";
                $html .= buildCategory($cat_id, $category, $existing_categories);
                $html .= "</li> \n";
            }
        }
        $html .= "</ul> \n";
    }
    return $html;
}

function buildHeader($parent, $category, $subs = "") {
    $html = "";
    if (isset($category['parent_cats'][$parent])) {
        
            $class = $parent == 0 ? "megamenu skyblue" : "";
            $style = $parent == 0 ? "width:100%" : "";
                        $html .= "<ul class='".$class."' style='".$style."'>\n";
            
            if($parent == 0)
                $html .= '<li class="grid"><a class="color1" href="<?php echo site_url(); ?>">Home</a></li>';
            
            $color = 2;
            foreach ($category['parent_cats'][$parent] as $cat_id) {
                
                $color = $color > 10 ? 1 : $color;
                
                if (!isset($category['parent_cats'][$cat_id])) { 
                    $html .= '<li class="grid"><a class="color'.$color.'" href="<?php echo site_url(); ?>">'.$category['categories'][$cat_id]['name'].'</a></li>';
                }
                if (isset($category['parent_cats'][$cat_id])) {
                    
                    $clr_class = $subs == "subs" ? "" : "color";
                    $clr_class = $subs == "subs" ? "" : "color";
                    
                    $html .= '<li class="grid"><a class="'.$clr_class.$color.'" href="<?php echo site_url(); ?>">'.$category['categories'][$cat_id]['name'].'</a>';
                   
                    $sub_class = $subs == "subs" ? "" : "megapanel";
                    $col_class = $subs == "subs" ? "" : "col1";
                    
                    $html .= '<div class="'.$sub_class.'"><div class="row">';
                    $html .= '<div class="'.$col_class.'"><div class="h_nav">';
                        $html .= buildHeader($cat_id, $category, "subs");
                    $html .= '</div></div><div class="clearfix"></div> </div></div></li>';
                }
                
                ++$color;
            }
            
            $html .= "</ul> \n";
        
    }
    return $html;
}

function uploadFiles($name, $path, $config=array()){
    $CI     =& get_instance();
    
    if(count($config) == 0){
        $config = array(
            'upload_path'   => FCPATH.$path,
            'allowed_types' => '*',
            'overwrite'     => TRUE,                       
        );
    }
    $CI->load->library('upload', $config);
    if ( ! $CI->upload->do_upload($name))
        return array("status" => FLASE, "msg" => $CI->upload->display_errors());
    else
        return array("status" => TRUE, "data" => $CI->upload->data());
}

function uploadMultiFiles($name, $path){
    $result = array();
    if(is_array($name)){
        $_FILES['uploadfile']['name'] = '';
        foreach ($name['name'] as $key => $image) {  
            if (!empty($image)) { 
                $_FILES['uploadfile']['name']       = $name['name'][$key];
                $_FILES['uploadfile']['type']       = $name['type'][$key];
                $_FILES['uploadfile']['tmp_name']   = $name['tmp_name'][$key];
                $_FILES['uploadfile']['error']      = $name['error'][$key];
                $_FILES['uploadfile']['size']       = $name['size'][$key];
                $result[$key] = uploadFiles('uploadfile', $path);
            }
        }
    }
    return $result;
}

function resizeImages($filepath){
    $imageSizes      = array('large', 'medium', 'small');
    foreach ($imageSizes as $value) {
        $fileDestination = FCPATH.'/assets/products/img/'.$value.'/';
        switch ($value) {
            case 'large':
                $width  = PRODUCT_IMAGE_LARGE_WIDTH;
                $height = PRODUCT_IMAGE_LARGE_HEIGHT;
                break;
            case 'medium':
                $width  = PRODUCT_IMAGE_MEDIUM_WIDTH;
                $height = PRODUCT_IMAGE_MEDIUM_HEIGHT;
                break;
            case 'small':
                $width  = PRODUCT_IMAGE_SMALL_WIDTH;
                $height = PRODUCT_IMAGE_SMALL_HEIGHT;
                break;
        }
        do_resize($filepath, $fileDestination, $width, $height);
    }
}

function do_resize($filename, $destination, $width, $height){ 
    $CI             =& get_instance();
    $source_path    = $filename;
    $type           = exif_imagetype($source_path);
    $file_name      = basename($source_path);
    list($src_width, $src_height, $src_type, $src_attr) = getimagesize($source_path);
    
    $config_manip   = array(
        'image_library'     => 'gd2',
        'source_image'      => $source_path,
        'new_image'         => $destination,
        'maintain_ratio'    => TRUE,
        'create_thumb'      => TRUE,
        'thumb_marker'      => '',
        'width'             => $width,
        'height'            => $height,
        'quality'           => '90%',    
        'master_dim'        => $src_width >= $src_height ? 'width' : 'height'
    ); 
    
    $CI->load->library('image_lib');
    
    $CI->image_lib->initialize($config_manip);
    $uploaded = $CI->image_lib->resize(); 

    $config_manip['quality']   = '1%';
    $config_manip['new_image'] = $destination.'low-'.$file_name;

    $CI->image_lib->initialize($config_manip);
    $uploaded = $CI->image_lib->resize();    
        
    if (!$uploaded) {
        echo $CI->image_lib->display_errors();
    }
    $CI->image_lib->clear();
    return;
}
    