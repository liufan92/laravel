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

	$('.postComment').on('click', function(event){
		var username;
		var created_at;
		event.preventDefault();
		articleId = $(this).siblings('[name=article_id]').val();
		userId = $(this).siblings('[name=user_id]').val();
		comment = $(this).siblings('[name=text]').val();
		$.ajax({
			context: this,
			method: 'POST',
			url: urlComment,
			data:{articleId: articleId, text: comment, _token: token },
			success: function(data){
				username = data['username'];
				created_at = data['created_at'];
				$(this).siblings('[name=text]').val('');
				var commentSection = $(this).parent();
				$('<p>'+username+' : <i>'+comment+'</i> <span class="pull-right">'+data['created_at']+'</span></p>').insertAfter(commentSection);
			}
		});

		
		//commentSection.insertAfter(comment, commentSection.childNode[0]);
	});

});