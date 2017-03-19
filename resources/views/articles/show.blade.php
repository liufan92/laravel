@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span>

					{{ $article->user->name }}
					@if($article->user_id == Auth::id())
					<small>
						<a href="/articles/{{ $article->id }}/edit">Edit</a>
					</small>
					@endif
				</span>
				<span class="pull-right">
					{{ $article->created_at->diffForHumans() }}
				</span>
			</div>
			
			<div class="panel-body">
				{{ $article->content }}
				<hr>
				<form method="POST" action="/comments">
					{{csrf_field()}}
					<input type="hidden" name="user_id" value="{{Auth::id()}}">
					<input type="hidden" name="article_id" value="{{$article->id}}">
					<input type="text" name="text" size="50" placeholder="Say Something...">
					<button class="btn btn-primary btn-sm">Send</button>
				</form>
				<hr>
				@forelse($comments as $comment)
				<p>{{$comment->user->name}} : <i>{{$comment->text}}</i> <span class="pull-right">{{$comment->created_at->diffForHumans()}}</span></p>
				<hr>
				@empty
				<p>No comments yet</p>
				@endforelse
			</div>
		</div>
	</div>
</div>
@endsection