@extends('admin.dashboard')

@section('admin')
<div id="formContainerAdmin" class="container">
	{!! $form !!}

</div>
@endsection

@section('js_form')

<script>


if (typeof jQuery === "undefined") {
  throw new Error("Data-table requires jQuery");
}

(function ($){
    'use strict';

    try{

var PostForm = function  (data, url) {

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		        'Content-Type': 'application/json'
		    }
		});
	
	  	$.ajax({
	            url: url,
	            type: 'post',
	            data: JSON.stringify(data),	           
	           	cache:false
	        })
		    .done(function(xhr, e, s){
		    	window.localStorage.responseServer= "ok";
				console.log('DONE: ', xhr, e, s);
		    })
			.fail(function(e, s){
		        console.log('FAIL: ',e, s);
		    });
}

const content = $('#formContainerAdmin.container');
const location= window.location;
const pathname= '/api'+location.pathname;


	var data= content.find('form');
	data.each( function(){

	var ObjectForm= $(this);
	var IdBtn= "";

	
	ObjectForm.each( function(){
		var ObjectData= $(this);
		var button= ObjectData.find('button');

		if(ObjectData.has('select')){
			var SelectOption= ObjectData.find('select');

			SelectOption.each( function(e){
				var selectId= $(this).attr('id');
				console.log('selected', $('#'+selectId));

				$(document).on('change', '#'+selectId, function(e) {
	 				 console.log('id', e, $(this));
				});
			});

			
			
	
		}

		$.each(button, function(){
			 IdBtn= $(this).attr('id');
		});
			
		$(document).on('click', $('#'+IdBtn), function(e) {
			e.preventDefault();		
			var target= e.target.name;	
				switch(target) {
			    	case 'update':
						console.log('enviando...', location);
						PostForm(ObjectData.serializeArray(), pathname); 
						console.log('responseServer: ',localStorage.responseServer)
					break;
					case 'create':
					    console.log('enviando...', location);

					    PostForm(ObjectData.serializeArray(), pathname); 
					break;
					case 'cancel':
					    console.log('user: '+target);
					    window.location = '/admin/grid/'+IdBtn;
					break;
				} 
		});
	});
});

}catch(e){

        console.log('Error: ',e);
    }

    })(jQuery);//


</script>


@endsection