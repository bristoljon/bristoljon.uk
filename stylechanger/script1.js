$(document).ready(function(){

	var windowheight = $(window).height();

	$(".navbuttons li").click(function() {

		$(".navbuttons li").removeClass("active");

		$(this).addClass("active");

		$(".navbuttons li").not(".active").find("ul").fadeOut(300);

		$(this).find("ul").fadeToggle(300);
	});


	$(document).scroll(function() {
		$(".navbuttons li").find("ul").fadeOut(300);
		$(".navbuttons li").removeClass("active");

		var currentScroll = ($(window).scrollTop())*1.5;

		var startingOffset = -300;

		var offset = currentScroll+startingOffset;

		$("#jumbotron").css("background-position","0px "+offset+"px");
	});

});