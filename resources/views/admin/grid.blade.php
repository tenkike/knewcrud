@extends('admin.dashboard')

@section('admin')
<div class="container">

	@if(\Request::segment(2) == 'grid')
	<div class="table-responsive-md">
		
		{!! $grid !!}
	</div>
	@endif

	

</div>
@endsection