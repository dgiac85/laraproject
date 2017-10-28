<?php
/*
Author:Giacomo Delfini
Date:24 giu 2017
Time:20:12:00
File:albums.blade.php
*/


?>

@extends('templates.default')
@section('title',$title)
@section('content')
@if(session()->has('message'))
	@component('components.alert-info')
	{{session()->get('message')}}
	@endcomponent
@endif	
<form>
	<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
	<ul class="list-group">
	@foreach($albums as $album)
		<li class="list-group-item justify-content-between">
			@if($album->album_thumb)
					<img  width="300" src="{{asset($album->path)}}" alt="{{$album->album_thumb}}">
				@endif
			<p>{{$album->id}} {{$album->album_name}}</p>
			<div>
				@if ($album->photos_count)
					<a href="/albums/{{$album->id}}/images" class="btn btn-primary"> View Images ({{$album->photos_count}})</a>
				@endif
				<a href="/albums/{{$album->id}}/edit" class="btn btn-primary">Update</a>
				<a id="delete" href="/albums/{{$album->id}}" class="btn btn-danger">Delete</a>
				
			</div>
		</li>
  	@endforeach
  	</ul>
  </form>
@endsection

@section('footer')
	@parent <!--sto prendendo il footer dal template padre ovvero default.blade.php-->
	<script>
	$(document).ready(function(){
		$('div.alert').fadeOut(3000);
		
		$('ul').on('click','a', function(element){ //solo click su elementi di tipo 'a'
		
	
			if (element.target.id=="delete"){
				element.preventDefault();
				var urlAlbum=$(this).attr('href');
				var li=element.target.parentNode;
				//evitiamo il caricamento ad altra pagina. è js che gestisce il click
			
				$.ajax(urlAlbum,
					{
						method:'DELETE',
						data:{
							'_token':$('#_token').val()
						},
						complete: function(response){
							if (response.responseText=='1'){
								li.parentNode.remove();
								//$(li).remove(); è la stessa cosa dell'istruzione precedente
								//alert(response.responseText);
							} else {
								alert('Problems occured while contacting server');
							}
							
						}
					}
				)
			}

		});
	});
</script>	
@endsection
