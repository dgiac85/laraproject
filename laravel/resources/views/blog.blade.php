@extends('templates/default')

@section('title',$title)

@section('content')
	<h1>blog</h1>
	@component('components.card',
		[
			'img_title' => 'Image blog',
			'img_url' =>  'http://lorempixel.com/400/200'
		])

		<p>Ciao!</p>
	@endcomponent

	@component('components.card')
		@slot('img_title','Image blog')
		@slot('img_url','http://lorempixel.com/400/200')

		<p>Ciao!</p>
	@endcomponent
@endsection('content')

@include('components.card')

@include('components.card', [
			'img_title' => 'Image blog',
			'img_url' =>  'http://lorempixel.com/400/200'
		])

@section('footer')
	@parent <!--sto prendendo il footer dal template padre ovvero default.blade.php-->
	<script>console.log('blog')</script>
@endsection