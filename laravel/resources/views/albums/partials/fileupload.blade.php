<?php
/*
Author:Giacomo Delfini
Date:23 ott 2017
Time:23:32:22
File:fileupload.blade.php
*/
?>

<div class="form-group">
<label for="">Thumbnail</label>
<input type="file" name="album_thumb" id="album_thumb" class="form-control">
@if($album->album_thumb)
<img src="{{$album->album_thumb}}" title="{{$album->album_thumb}}" alt="{{$album->album_thumb}}">
@endif
</div>

