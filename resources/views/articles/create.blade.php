<header><h3>What's in your mind?</h3></header>
<!--@if(Session::has('message'))
<div class="row">
	<div class="col-md-8 col-md-offset-2 success">
		{{ Session::get('message') }}
	</div>	
</div>
<hr>
@endif-->
<form method="POST" action="/articles">
	{{ csrf_field() }}
	<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
	<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
		<textarea class="form-control" name="content" id="new-post" rows="5" placeholder="Write something..."></textarea>
		@if ($errors->has('content'))
            <span class="help-block">
                <strong>{{ $errors->first('content') }}</strong>
            </span>
        @endif
	</div>
	<!--<div class="checkbox">
		<label>
			<input type="checkbox" name="live">Live
		</label>
	</div>
	<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
		<label for="post_on">Post on</label>
		<input type="datetime-local" name="post_on" class="form-control">
		@if ($errors->has('post_on'))
            <span class="help-block">
                <strong>{{ $errors->first('post_on') }}</strong>
            </span>
        @endif
	</div>-->
	<button type="submit" class="btn btn-primary">Create Post</button>
</form>