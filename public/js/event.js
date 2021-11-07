$(document).ready(function(){
	$(".navbar__item.item__link_parent").click(function() {
		$(this).children(".navbar__treeview").toggle(250);
	});
	$(".mMenu__header").click(function() {
		$(".app__navbar").toggle(250);
	});
	
	$(document).mouseup(function(e) {
		var screen_width = $(window).width();
		if(screen_width <= 1024){
			var container = $(".app__navbar");
	    	if (!container.is(e.target) && container.has(e.target).length === 0) {
	           container.hide();
	     	}	
		}
    })
})