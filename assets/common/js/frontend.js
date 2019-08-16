(function ( $ ) {

	$.fn.products   = function(data={}, method='GET'){
		var e       = $(this);
		var url     = '/posibolt/api/products/all';
	    var request = ajaxCall(url, data, method);	 
	    request.done(function( data ) {
			var productData = '';
			for(let i=0; i< data.length; i++){
				var product = 	data[i];
				console.log("PROD",product);
				productData +=  '<li data-category="formal" data-style="circle"'
    								+'data-color="blue" data-gender="man" data-available="150"'
    								+'data-price="'+product.basePrice+'" data-name="'+product.short_name+'"'
    								+'class="mix product-item filter-target available Seasonal Fall_2019 Mens Equipment Running Team_Footbal Black">';
				
				productData +=  	'<div class="product-thumb clearfix">'
        								+'<a href="#">'
            								+'<img src="'+product.thumbs.small+'" alt="image">'
        								+'</a>'
    									//+'<span class="new">Pre-order</span>'
    								+'</div>'
    								+'<div class="product-info clearfix">'
    									+'<div class="product-title-container">'
            								+'<span class="product-title name">'+product.short_name+'</span>'
        								+'</div>'
        								+'<div class="sku-delivery">'
								            +'<span class="product-sku">'+product.model+'</span>'
								            +'<span class="product-delivery-date">'+product.deliveryIn+'</span>'
								        +'</div>'
								        +'<div class="price">'
            								+'<span class="price-before">R'+product.strike_price+'</span>'
        									+'<span class="price-after">'+product.displayPrice+'</span>'
        								+'</div>';
				var attributes  =   product.attributes ? product.attributes : false;
				
				if(attributes.attributes){
					productData += productVariants(attributes.attributes);
				}
				productData +=  '</div>';
				productData +=  '<div class="thumb">'
                                    +'<div class="add-to-cart text-center buy">'
                                        +'<a class="buynow" href="#qwe">ADD TO CART</a>'
                                    +'</div>'
                                +'</div>'
                                +'<a href="#" class="like"><i class="fa fa-heart-o"></i></a>';
				productData +=  '</li>';
			}
			e.html(productData);
		});

		request.fail(function( jqXHR, textStatus ) {
		  e.html('<li>No products available!');
		});
	}

	$.fn.categories = function(data={}, method='GET') {
		var e       = $(this);
		var url     = '/posibolt/api/products/categories';
	    var request = ajaxCall(url, data, method);	 
		request.done(function( data ) {
			var accordion = '';
			for(let i=0; i< data.length; i++){
				accordion += '<div class="item">'
	            			 +'<input id="cat-'+data[i].cat_id+'" type="radio" name="accordion" hidden="hidden"/>'
	            			 +'<label class="menulabel" for="cat-'+data[i].cat_id+'">'+data[i].cat_display_name+'</label>';
				if(data[i].sub_categories && data[i].sub_categories.length > 0){
					accordion += '<div class="acoordion-content">';
					accordion += subCategory(data[i].sub_categories);
					accordion += '</div>';
				}
			 	accordion += '</div>';
			}
			e.html(accordion);
		});
	 
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}

	
}( jQuery ));

function ajaxCall(url, data, method){
	return $.ajax({
		  	url     : url,
		  	method  : method,
		  	data    : data,
		  	dataType: 'json'
		});
}

function togglerMenu(id) { 
    var checkBox = document.getElementById(id);
    var text     = document.getElementById('toggle-'+id);
    if(!text)
        return;
    
    if (checkBox.checked == true){
      text.style.display = "block";
    } else {
       text.style.display = "none";
    }
}

function productVariants(variants){
	var variantsData 	  = '<div class="input-options">'; 
	for (var key in variants) {
		var variant  	  = variants[key]; console.log('VARIENT', variant);
		for (var index in variant.attribute_options) {
			var attribute = variant.attribute_options[index];
			var attrName  = attribute.option_name;	
			variantsData += '<div class="form-group row form-input-options">'
								+'<label class="col-sm-8 col-form-label input-opt-label">'+attrName+'</label>'
								+'<div class="col-sm-3">'
	        						+'<input type="number" class="form-control input-opt-add" placeholder="1">'
	    						+'</div>'
							+'</div>';
		}
	}
	variantsData    += '</div>';
	return variantsData;
}

function subCategory(subs){
	var subText = '';
	for(let i=0; i< subs.length; i++){
		var cleanString = clean(subs[i].cat_display_name); 
		subText += '<div class="form-check">'
              		+ '<input id="'+cleanString+'" class="form-check-input '+cleanString+'" name="'+cleanString+'" type="checkbox" value="'+subs[i].cat_id+'" onclick="togglerMenu(\''+cleanString+'\')">'
              		+ '<label class="form-check-label">'
              			+ subs[i].cat_display_name
              		+ '</label>';
  		if(subs[i].sub_categories && subs[i].sub_categories.length > 0){
			subText += '<div class="toggler" id="toggle-'+cleanString+'" style="display:none">';
			subText += subCategory(subs[i].sub_categories);
			subText += '</div>';
		}

        subText += '</div>';
	}
	return subText;  	
}

function clean(str=''){
	var cleanString = str.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
	return cleanString.replace(" ", "-");
}
