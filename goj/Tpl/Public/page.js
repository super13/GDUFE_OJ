$(document).ready(function() {
    $('#totop').click(function(){
        $('html, body').animate({scrollTop:0}, '500');
    });

    $(window).bind('scroll', function() {
	       var navcss = { position: 'fixed', top: '0px' };
		var	scrollPos = $(window).scrollTop();
		if(scrollPos > 120) $('#mainnav').css(navcss);
		else {
		$('#mainnav').css('position', 'static' );	
		}
	});
});
