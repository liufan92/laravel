@extends('layouts.app');

@section('content')
	<section class="row new-post">
		<div class="col-md-6 col-md-offset-3">
			@include('articles.create')
		</div>
	</section>
	<section class="row posts">
		<div class="col-md-6 col-md-offset-3">
			<header><h3>What other people say...</h3></header>
			@forelse($articles as $article)
				<article>
					<div class="post" data-id="{{$article->id}}">
						<p>{{ $article->content }}</p>
						<div class="info">
							Posted by {{ $article->user->name }} {{ $article->created_at->diffForHumans() }}
						</div>
						<div class="interaction">		
							
								<a class="like" href="#"><i class="fa fa-thumbs-o-up" aria-hideen="true"> Like</i></a> |
								<a class="toggleComment" href="#"><i class="fa fa-comment-o" aria-hideen="true"> Comment</i></a> 
								@if($article->user_id == Auth::id())
								<!--<a class="editPost" href="/articles/{{$article->id}}/edit">| <i class="fa fa-pencil-square-o" aria-hideen="true"> Edit</i></a>-->
								<a class='editPost' data-toggle="modal" data-target="#edit-modal" href="#">| <i class="fa fa-pencil-square-o" aria-hideen="true"> Edit</i></a>
								<form action="/articles/{{$article->id}}" method="POST" class="pull-right">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm">
										<i class="fa fa-trash-o" aria-hideen="true"> Delete</i>
									</button>
								</form>
							@endif
						</div>
					</div>
					
					<!--  Comment section  -->
					<aside class="comment">
						<form method="POST" action="{{route('comment.post')}}">
							{{csrf_field()}}
							<input type="hidden" name="user_id" value="{{Auth::id()}}">
							<input type="hidden" name="article_id" value="{{$article->id}}">
							<input type="text" name="text" size="50" placeholder="Say Something...">
							<button class="btn btn-primary btn-sm">Send</button>
						</form>
						@forelse($article->comments as $comment)
						<p>{{$comment->user->name}} : <i>{{$comment->text}}</i> <span class="pull-right">{{$comment->created_at->diffForHumans()}}</span></p>
						@empty
						<p>No comments yet</p>
						@endforelse
					</aside>
				</article>
				<!--  End of Comment  -->
			@empty
				<article>
					<p>Nothing to show :(</p>
				</article>
			@endforelse
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				{{ $articles->links() }}
			</div>
		</div>
	</section>

	<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Post</h4>
				</div>
					<div class="modal-body">
						<form id="editPostForm" action="" method="POST">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<label for="content">{{Auth::user()->name}}</label>
							<textarea name="content" class="form-control" id="editPostBody" rows="5"></textarea>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" form="editPostForm" class="btn btn-primary">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<script>
		var token = '{{ Session::token() }}';
	</script>
@endsection
