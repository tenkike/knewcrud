@extends('admin.dashboard')

@section('admin')
<div class="container">
<h1> {{$title}} </h1>

	@if(\Request::segment(2) == 'grid')
	<div class="table-responsive-md">
		
	</div>
	@endif

	

</div>
@endsection