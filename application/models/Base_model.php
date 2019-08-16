<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Model extends CI_Model
{
  	public  $where 			= array();
  	private $featuredImage 	= '';

	function getAllProducts($limit, $page, $search_text = null, $category = null){
		$db 			 = $this->settingsLoader();	
		$start 			 = ($page-1)*$limit;
		$db->select('p.id as product_id, p.short_name, p.long_name, p.model, p.short_description, p.long_description, p.sku, p.page_title, p.meta_keys, p.meta_description, p.price as basePrice, p.strike_price, p.strike_status, p.inventory, p.stock_min, p.stock, CONCAT("[",GROUP_CONCAT(JSON_OBJECT("image", image,
      		"featured", i.featured)),"]") as images');

		$db->from("products p")
			 ->join("images i", "i.product_id = p.id", "left");	

		if($search_text != null){
			$search_text = urldecode($search_text);
            $db->where("(p.short_name LIKE '%$search_text%')");			
		}	

		if($category    !== null){
			$db->join('product_categories pc', 'pc.product_id = p.id');
			$db->where("pc.category_id", $category);
		}	
		$db->order_by('p.id', 'desc');
		$db->group_by('p.id');		
		$db->limit($limit, $start);
		$query 		= $db->get();

		//echo $db->last_query();

		$productIds = array();
		if($query->num_rows() > 0){
			$products = $query->result();
			foreach ($products as $key => $product) {
				if(empty($product->images))
					continue;	
				$images 		 = json_decode($product->images, true);	
				$product->images = $this->imageCheckerProducts($images);

				$product->thumbs = array(
					'original' => getProductImage($this->featuredImage, 'original'),
					'small'    => getProductImage($this->featuredImage, 'small'),
					'medium'   => getProductImage($this->featuredImage, 'medium'),
					'large'    => getProductImage($this->featuredImage, 'large')
				);
				$product->displayPrice = displayPrice($product->basePrice);
				$product->price        = calculatePrice($product->basePrice);
				$product->deliveryIn   = calculateDeliveryDate();	
				$productIds[]          = $product->product_id;
			}
			return array("products" => $products, "product_ids" => $productIds);
		}
		return false;
	}

	function getOneProduct($productId){
		$db 			 = $this->settingsLoader();	
		$db->select('p.id as product_id, p.short_name, p.long_name, p.model, p.short_description, p.long_description, p.sku, p.page_title, p.meta_keys, p.meta_description, p.price as basePrice, p.strike_price, p.strike_status, p.inventory, p.stock_min, p.stock, CONCAT("[",GROUP_CONCAT(JSON_OBJECT("image", image,
      		"featured", i.featured)),"]") as images');

		$db->from("products p")
			 ->join("images i", "i.product_id = p.id", "left");	
	 	$db->where("p.id", $productId);
		$db->group_by('p.id');		
		$query 		= $db->get();
		if($query->num_rows() > 0){
			$product = $query->row();
			if(!empty($product->images)){
				$images 		 = json_decode($product->images, true);				
				$product->images = $this->imageCheckerProducts($images);
			}
			return $product;
		}	
		return false;
	}

	function getProductAttributes($productIds){
		$db 			 	  = $this->settingsLoader();	
		if(count($productIds) == 0)
			return false;
		$db->select("pa.product_id, ag.name as group_name, a.id as attribute_id, a.name as attribute_name, ao.id as attribute_option_id, ao.name as option_name, ao.sort as optionSort, ai.image_id, spa.sku, spa.attribute_id1, spa.attribute_id2, spa.attribute_id3, spa.attribute_id3, spa.attribute_id4, spa.attribute_id5, spa.quantity, spa.price_variation, spa.min_quantity");

		$db->from("product_attributes pa")
			 ->join("attribute_groups ag", "ag.id = pa.group_id")
			 ->join("attribute_option_groups aog", "aog.group_id = ag.id")
			 ->join("attributes a", "a.id = aog.attribute_id")
			 ->join("attribute_options ao", "ao.attribute_id = a.id")
			 ->join("stock_price_attributes spa", "spa.group_id = ag.id AND spa.product_id = pa.product_id", "left")
			 ->join("attribute_images ai", "ai.attribute_id = ao.id AND ai.product_id = pa.product_id", "left");

	 	$db->where_in("pa.product_id", $productIds); 
	 	$query 				= $db->get();
		$productAttributes  = $attributeData      = array();
		$attributeIds	    = $attributeOptionIds = $allAttributes = array();
		$index				= 0;
		
		//echo $db->last_query();

	 	if($query->num_rows() > 0){ 
	 		$attributes     = $query->result();
	 		foreach ($attributes as $key => $attribute) { 
 				$productId   		     = $attribute->product_id; 
 				$attributeId 		     = $attribute->attribute_id;
 				$attributeOptionId 	     = $attribute->attribute_option_id;
				$productAttributeId      = $productId.$attributeId;
				$prouctAttributeOptionId = $productAttributeId.$attributeOptionId;	
				$attributeOptionSort     = $attribute->optionSort;

				$allAttributes[$attributeOptionId] = $attribute->option_name;

				if(!in_array($productAttributeId, $attributeIds)){
		 			$attributeData[$productId]['attributes'][$attributeId] = array(
		 				"attribute_name" 	=> $attribute->attribute_name,
		 				"attributeId"	 	=> $attributeId,
		 			);
		 			$attributeIds[] = $productAttributeId;	
	 			} 
	 			$attributeData[$productId]['attributes'][$attributeId]["attribute_options"][$attributeOptionSort.$attributeOptionId] = 
	 					array(
	 						"option_id"   => $attributeOptionId,
	 						"option_name" => $attribute->option_name,
	 						"image_id"	  => $attribute->image_id	
	 					);
	 			if(!$attribute->attribute_id1){
	 				$productAttributes[$productId] = $attributeData[$productId];
	 				continue;			
	 			}
				$stockIndex      = $attribute->attribute_id1.$attribute->attribute_id2.$attribute->attribute_id3.$attribute->attribute_id4.$attribute->attribute_id5;
 				$attributeData[$productId]["stockData"]["$stockIndex"] = array(
 					"stock" 		=>   $attribute->quantity,
 					"attribute_id1" =>   $attribute->attribute_id1,
 					"attribute_id1_name" => $allAttributes[$attribute->attribute_id1],
 					"attribute_id2" => $attribute->attribute_id2,
 					"attribute_id2_name" => $allAttributes[$attribute->attribute_id2],
 					"attribute_id3" => $attribute->attribute_id3,
 					"attribute_id3_name" => $allAttributes[$attribute->attribute_id3],
 					"attribute_id4" => $attribute->attribute_id4,
 					"attribute_id4_name" => $allAttributes[$attribute->attribute_id4],
 					"attribute_id5" => $attribute->attribute_id5,
 					"attribute_id5_name" => $allAttributes[$attribute->attribute_id5],
 				);
	 			$productAttributes[$productId] = $attributeData[$productId];
	 		} 
	 		return $productAttributes;
	 	}
	 	return false;
	}

	function getAllCategories($inMenu=FALSE){
		$db 	= $this->settingsLoader();
		$db->select("c.id as cat_id, c.sort,c.name as cat_name, c.display_name as cat_display_name, c.parent_id as cat_parent, c.in_menu");
		$db->order_by("c.sort, c.parent_id", "asc");
		$inMenu ? $db->where("c.in_menu", 1): "";
		$query      = $db->get("categories c");
        $categories = array();
        if($query->num_rows() > 0){ 
        	$parentCategories = $subCategories = array();
        	$parentTemp		  = $subTemp	   = array();			
        	$categoriesData   = $query->result(); 
        	
        	foreach ($categoriesData as $key => $category) {
        		if($category->cat_parent == 0){
        			$parentCategories[] 	= (Object)array(
        				"cat_name" 			=> $category->cat_name, 
        				"cat_id"   			=> $category->cat_id, 
        				"cat_display_name" 	=> $category->cat_display_name,
        				"in_menu"			=> $category->in_menu
        			);
        		} else{
        			$subCategories[$category->cat_parent][] = (Object)array(
        				"cat_name" 			=> $category->cat_name, 
        				"cat_id"   			=> $category->cat_id, 
        				"cat_display_name" 	=> $category->cat_display_name,
        				"in_menu"			=> $category->in_menu
        			);
        		}
        	}
        	foreach ($parentCategories as $key => $parent) {
        		if(isset($subCategories[$parent->cat_id] ) ) {
        			$tempData = $subCategories[$parent->cat_id];
        			foreach ($tempData as $key => $subCat) {
        				if(isset($subCategories[$subCat->cat_id] ) ) { 
        					$subCat->sub_categories = $subCategories[$subCat->cat_id];
        				}
        			}
        			$parent->sub_categories = $tempData;
        		}
        		$categories[] = $parent;
        	}
        	return $categories;
        }
        return FALSE;
	}

	function settingsLoader(){
		if(count($this->where) > 0){
			$this->db->where($this->where);
			$this->where = array();
		}	
		return $this->db;
	}

	function imageCheckerProducts($images){
		$productImages			= array();
		$this->featuredImage 	= NULL;
		foreach ($images as $key => $image) { 
			if($image['image']){
				$productImages[] = $image;

				if($image['featured'] == 1){
					$this->featuredImage = $image['image'];
				}
			}
		}
		if(count($productImages) == 0)
			$productImages[] = array('image' => 'not_found.jpg', 'featured' => 1);

		if($this->featuredImage == NULL)
			$this->featuredImage = $productImages[0]['image'];
		return $productImages;
	}
}