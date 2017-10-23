<?php
/*
Author:Giacomo Delfini
Date:05 ago 2017
Time:16:08:08
File:createalbum.blade.php
*/
?>
@extends('templates.default')
@section('title',$title)
@section('content')
<h1>Create a New Album</h1>
<form action="{{route('album.save')}}" method="POST" enctype="multipart/form-data">
{{csrf_field()}}

<div class="form-group">
<label for="name"></label>
<input type="text" name="name" id="name" class="form-control" value="" placeholder="Name">

</div>
<div class="form-group">
<label for="description"></label>
<textarea name="description" id="description" class="form-control"  placeholder="Description">
</textarea>
</div>
@include('albums.partials.fileupload')
<button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection