function simple_tooltip(target_items, name){
 $(target_items).each(function(i){
		$("body").append("<div class='"+name+"' id='"+name+i+"'>"+$(this).attr('title')+"</div>");
		var my_tooltip = $("#"+name+i);

		if($(this).attr("title") != "" && $(this).attr("title") != "undefined" ){

		$(this).removeAttr("title").mouseover(function(){
					my_tooltip.css({display:"none"}).fadeIn(400);
		}).mousemove(function(kmouse){
				var border_top = $(window).scrollTop();
				var border_right = $(window).width();
				var left_pos;
				var top_pos;
				var offset = -8;
				if(border_right - (offset *2) >= my_tooltip.width() + kmouse.pageX){
					left_pos = kmouse.pageX+offset-25;
					} else{
					left_pos = border_right-my_tooltip.width()-offset-25;
					}

				if(border_top + (offset *2)>= kmouse.pageY - my_tooltip.height()){
					top_pos = border_top +offset;
					} else{
					top_pos = kmouse.pageY-my_tooltip.height()+(offset*2);
					}

				my_tooltip.css({left:left_pos, top:top_pos});
		}).mouseout(function(){
				my_tooltip.css({left:"-9999px"});
		});

		}

	});
}

$(document).ready(function () {
simple_tooltip(".tooltip","tooltip-cloud");	

$(".list-features ul li:nth-child(3n)").addClass("nomargin");

$(".showmap").click(function(){
	$('html, body').animate({scrollTop:0}, 400);	
	
	$("#mappop-holder").css("filter", "alpha(opacity=90)");
	$("#mappop-holder, #mappop").delay(400).css("visibility","visible").hide().fadeIn('slow');
	});

	
	
	$("#mappop-holder, #mappop-close").click(function(){
		$("#mappop-holder, #mappop").fadeOut(300).css("visibility","hidden");
});

$(".try-container .btn-try").mouseenter(function(){
	$(this).find("a.hover").fadeIn(200).mouseleave(function(){$(this).fadeOut(200)});
});



/* autoclear function for inputs */
$('.autoclear').click(function() {
if (this.value == this.defaultValue) {
this.value = '';
}
});
$('.autoclear').blur(function() {
if (this.value == '') {
this.value = this.defaultValue;
}
});

$('.gotop').click(function(){
	$('html, body').animate({scrollTop:0}, 'slow');
	return false;
});

});

