@extends('layout')
@section('content')
<section class="content-header">
	<h1>Add Group</h1>
</section>
<!-- Main content -->
<section class="content container">
	<div class="col-md-10 col-sm-10 col-xs-10">
		<form action="/action_page.php">
		  <div class="form-group">
		    <label for="email">Name group :</label>
		    <input type="email" class="form-control" id="email">
		  </div>
		  <div class="form-group">
		    <label for="pwd">Password:</label>
		    <input type="password" class="form-control" id="pwd">
		  </div>

		  <button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</section>
@endsection
@section('js')
@endsection