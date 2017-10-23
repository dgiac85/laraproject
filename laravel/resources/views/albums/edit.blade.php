<?php
/*
Author:Giacomo Delfini
Date:22 lug 2017
Time:17:12:34
File:edit.blade.php
*/
?>

@extends('templates.default')
@section('title',$title)
@section('content')
<h1>Update Album</h1>
<form action="/albums/{{$album->id}}" method="POST" enctype="multipart/form-data">
{{csrf_field()}}
<input type="hidden" name="_method" value="PATCH">
<div class="form-group">
	<label for="name"></label>
	<input type="text" name="name" id="name" class="form-control" value="{{$album->album_name}}" placeholder="Name">

</div>
<div class="form-group">
	<label for="description"></label>
	<textarea name="description" id="description" class="form-control"  placeholder="Description">{{$album->description}}
	</textarea>
</div>
@include('albums.partials.fileupload')
<button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection