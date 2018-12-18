@extends('layout')
@section('content')
<section class="content-header">
	<h1>Add Feed</h1>
</section>
<!-- Main content -->
<section class="content container">
	<div class="col-md-10 col-sm-10 col-xs-10">
		<form action="{{ route('feeds.store') }}" method="post">
		{{csrf_token()}}
		  <div class="form-group">
		    <label for="email">Title :</label>
		    <input type="text" class="form-control" id="title" name="title">
		  </div>
		  <div class="form-group">
		    <label for="">Content :</label>
		    <textarea class="form-control" rows="5" id="content" name="content"></textarea>
		  </div>
		  <div class="form-group">
		    <label for="">Media :</label>
		    <input type="file" class="form-control" name="uploads" id="uploads">
		    <input type="hidden" name="group_id" value="{{$idgroup}}">
		    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
		  </div>

		  <button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</section>
@endsection
@section('js')

@endsection