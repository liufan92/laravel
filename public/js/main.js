$(document).ready(function(){

	$(".toggleComment").click(function(event){
		event.preventDefault();
		$(this).parent().parent().siblings('aside').toggle(500);
	})
});