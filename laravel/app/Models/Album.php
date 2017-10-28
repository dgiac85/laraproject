<?php
/*
Author:Giacomo Delfini
Date:20 giu 2017
Time:10:20:29
File:Album.php
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Album extends Model {
	//albums
	protected $table= 'albums'; //nel caso la classe si chiama in modo differente La tabella in mysql si chiama albums
	protected $orimaryKey='$id';
	protected $fillable = ['album_name','description','user_id'];
	
	
	public function getPathAttribute(){
		$url= $this->album_thumb;
		
		if (stristr($this->album_thumb,'http')===false){
			$url= 'storage/'.$this->album_thumb;			
		}
		
		return $url;
	
	}
	
	public function photos(){ //in questo modo dico che questo album ha tante foto
		
		return $this->hasMany(Photo::class,'album_id','id'); //la view ritorna le foto di un determinato album
		
	}
	 
	
}