<?php//blade: doppie parentesi per mostrare le variabili 
//e @ senza parentesi per fare i costrutti
?>

@extends('templates.default')
@section('title',$title)
@section('content')

<h1>
	{{$title}}
</h1>

@if($staff)
	<ul>
	@foreach ($staff as $person)
		<li> {{$person['name']}} {{$person['lastname']}} </li>
	@endforeach
	</ul>
@endif
<!--altrà modalità con forelse-->
<ul>
@forelse($stafforelse as $person)
		<li> {{$person['name']}} {{$person['lastname']}} </li>
		@empty <li>no staff --- picked from stafforelse variable</li>
@endforelse
</ul>

<h2>Staff names with for blade directive</h2>
@for($i=0; $i<count($staff); $i++)
	<p>{{$staff[$i]['name']}}</p>
@endfor

@endsection('content')