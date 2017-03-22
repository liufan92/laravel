$(document).ready(function(){
	var postId = 0;
	$(".toggleComment").on('click', function(event){
		event.preventDefault();
		$(this).parent().parent().siblings('aside').toggle(500);
	});

	$(".editPost").on('click', function(event){
		event.preventDefault();
		var postContent = $(this).parent().siblings('p').text();
		postId = $(this).parent().parent().data("id");
		$('#editPostBody').val(postContent);
		$('#editPostForm').attr('action','/articles/'+postId);
	});

	/*$('#modal-save').on('click', function(){
		$.ajax({
			method: 'POST',
			url: 'articles/'+ postId,
			data: {body: $('#editPostBody').val(), "&_token":token, _method:'PUT'}
		});
	});*/
});