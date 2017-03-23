@extends('layouts.app')

<style type="text/css">
	.profile-img{
		max-width: 150px;
		border: 5px solid #fff;
		border-radius: 100%;
		box-shadow: 0 2px 2px rgba(0,0,0,0.3);
	}	
</style>

@section('content')
	<section class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<img class="profile-img" src="http://www.lovemarks.com/wp-content/uploads/profile-avatars/default-avatar-french-guy.png">

					<h1>{{$user->name}}</h1>
					<h5>{{$user->dob->format('l j F Y')}} ({{$user->dob->age}} years old)</h5>
					<h5>{{$user->email}}</h5>

					<button class="btn btn-success">Follow</button>
				</div>
			</div>
		</div>
	</section>

	<section class="row new-post">
		<div class="col-md-6 col-md-offset-3">
			@include('articles.create')
		</div>
	</section>
	<section class="row">
		<div class="col-md-6 col-md-offset-3">
			<ul class="list-group">
				@forelse($articles as $article)
				<li class="list-group-item" style="margin-top: 20px">
					<span class="pull-left">{{$user->name}}</span>	
							
					<form action="/articles/{{$article->id}}" method="POST" class="pull-right">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button class="btn btn-sm">
							<i class="fa fa-trash-o" aria-hideen="true"> Delete</i>
						</button>
					</form>
					<span class="pull-right" style="margin-right: 10px">Posted {{$article->created_at->diffForHumans()}}</span>
					<a class="pull-right" href="/articles/{{$article->id}}/edit" style="margin-right: 10px">Edit</a>	
					<hr style="margin-top: 30px">
					<div>{{ $article->content }}</div>
				</li>
				@empty
				<h1>No articles to show. Create one now <a href="/articles/create">Create</a></h1>
				@endforelse
			</ul>
			{{ $articles->links() }}
		</div>
	</section>
				
			
</div>
@endsection