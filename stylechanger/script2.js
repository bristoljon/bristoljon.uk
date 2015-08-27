$(document).ready(function(){

	var windowheight = $(window).height();
	var flipSpeed =200;


	$(".navbuttons li").click(function() {

		$(".navbuttons li").removeClass("active");

		$(this).addClass("active");

		$(this).animate({width:200},flipSpeed,function() {
		
			$(".navbuttons li").not(".active").find("ul").fadeOut(300);

			$(this).find("ul").fadeToggle(300);
		})
	});


	$(document).scroll(function() {
		$(".navbuttons li").find("ul").fadeOut(300);
		$(".navbuttons li").removeClass("active");

		var currentScroll = ($(window).scrollTop())*1;

		var startingOffset = -195;

		var offset = currentScroll+startingOffset;

		$("#jumbotron").css("background-position","0px "+offset+"px");

		console.log($("#jumbotron").css("background-position"));
	});

});