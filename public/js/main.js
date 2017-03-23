$(document).ready(function(){
	var postId = 0;
	$(".toggleComment").on('click', function(event){
		event.preventDefault();
		$(this).parent().parent().siblings('aside').toggle(500);
	});

	$(".editPost").on('click', function(event){
		event.preventDefault();
		var articleContent = $(this).parent().siblings('p').text();
		articleId = $(this).parent().parent().data("id");
		$('#editPostBody').val(articleContent);
		$('#editPostForm').attr('action','/articles/'+articleId);
	});

	$(".like").on('click', function(event){
		event.preventDefault();
		articleId = $(this).parent().parent().data("id");
		$.ajax({
			method: 'POST',
			url: urlLike,
			data:{ articleId: articleId, _token: token }
		})
			.done(function(){
				event.target.innerText = event.target.innerText == ' Like' ? ' You liked This' : ' Like';
			});
	});

});