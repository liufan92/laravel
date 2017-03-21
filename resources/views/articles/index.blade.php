@extends('layouts.app');

@section('content')
	<section class="row new-post">
		<div class="col-md-6 col-md-offset-3">
			@include('articles.create');
		</div>
	</section>
	<section class="row posts">
		<div class="col-md-6 col-md-offset-3">
			<header><h3>What other people say...</h3></header>
			@forelse($articles as $article)
				<article>
					<div class="post">
						<p>{{ $article->content }}</p>
						<div class="info">
							Posted by {{ $article->user->name }} {{ $article->created_at->diffForHumans() }}
						</div>
						<div class="interaction">		
							
								<a class="like" href="#"><i class="fa fa-thumbs-o-up" aria-hideen="true"> Like</i></a> |
								<a class="toggleComment" href="#"><i class="fa fa-comment-o" aria-hideen="true"> Comment</i></a> 
								@if($article->user_id == Auth::id())
								<a href="/articles/{{$article->id}}/edit">| <i class="fa fa-pencil-square-o" aria-hideen="true"> Edit</i></a>
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
@endsection

<!--<div class="panel panel-default">
	<div class="panel-heading">
		<span>{{ $article->user->name }}</span>
		<span class="pull-right">{{ $article->created_at->diffForHumans() }}</span>
	</div>
	<div class="panel-body">
		{{ $article->shortContent }}

		<a href="/articles/{{ $article->id }}">Read More</a>
	</div>
	<div class="panel-footer clearfix" style="background-color: white">
		@if($article->user_id == Auth::id())
			<form action="/articles/{{$article->id}}" method="POST" class="pull-right" style="margin-left: 25px;">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
				<button class="btn btn-danger">
					Delete
				</button>
			</form>
		@endif
		<i class="fa fa-heart pull-right" ></i>
		
	</div>
</div>-->