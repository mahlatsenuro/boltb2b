$(function(){
	
	$(window).scroll(function(){
		var top = $(this).scrollTop();
		if(top > $('.shop').offset().top + 50) {
			$('.up').fadeIn('slow');
		} else {
			$('.up').hide();
		}
	});
	
	$('.up').click(function(){
		$('body, html').stop().animate({scrollTop: $('.shop').offset().top}, 500);
		return false;
	});
	
	$('.mobile-menu a').click(function(){
		var height = $('.sidebar').hasClass('sidebar-open') ? 0 : $('.sidebar #filters').outerHeight();
		$('.sidebar').toggleClass('sidebar-open').stop(true).animate({height: height}, 300);
		return false;
	});
	
	$(window).resize(function(){
		if(!$('.sidebar').hasClass('sidebar-open')) {
			$('.mobile-menu a').triggerHandler('click');
		}
	});

});