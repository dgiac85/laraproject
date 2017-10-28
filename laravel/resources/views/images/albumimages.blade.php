<?php
/*
Author:Giacomo Delfini
Date:28 ott 2017
Time:16:54:33
File:albumimages.blade.php
*/

?>
@extends('templates.default')
<table class="table table-striped">
    <tr>
        <th> CREATED DATE</th>
        <th> TITLE</th>
        <th> ALBUM</th>
        <th> THUMBNAIL</th>
        <th>&nbsp;</th>
    </tr>
    @forelse($images as $image)
     
        <tr>
            <td>{{$image->created_at->format('d/m/Y H:i')}}</td>
            <td>{{$image->name}}</td>
            <td><a href="#">{{$album->album_name}}</a> </td>
            <td>
              <img  width="120" src="{{asset($image->img_path)}}">
            </td>
            <td class="row">
                <a href="#" class="btn btn-sm btn-primary">
                    <span class="fa fa-pencil">Edit</span>
                </a>&nbsp;

                <a href="#" class="btn  btn-sm btn-danger">
                    <span class="fa fa-minus">Delete</span>
                </a>
            </td>
        </tr>
        @empty <!-- è jl ramo che si usa quando non ci sono immagini nell'oggetto images inviato dal controller tramite la funzione compact() -->
            <tr><td colspan="6">
                    No images found
                </td></tr>
        @endforelse