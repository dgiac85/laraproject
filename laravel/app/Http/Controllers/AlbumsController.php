<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use DB;

class AlbumsController extends Controller
{
    //index
    public function index(Request $request){
    	
    	$sql='select * from albums where 1=1'; //si ritorna 1=1 nel caso non si passano valori
    	$where=[];
    	if ($request->has('id')){
    		$where['id']=$request->get('id');
    		//$sql .= " AND id=:id";
    		$sql .= " AND id=:id";
    	}
    	if ($request->has('album_name')){
    		$where['album_name']=$request->get('album_name');
    		//var_dump($where['album_name']);
    		$sql .= " AND album_name=:album_name";
    		//$sql .= " AND album_name=:album_name";
    	}
    	//IMPORTANTE FILTRARE I DATI IN ARRIVO ALLA GET in modo da non avere SQL INJECTION
    	//dd($sql); //il dump ferma la query
    	
    	//al posto di array_values si può usare con i segnaposto :id o :album_name soltanto $where
    	//return DB::select($sql,$where);
    	//DB è una facade;
    	//return DB::select($sql,array_values($where)); //il select ci invia un array di record è ogni record è una stdClass che rappresenta una riga della tabella
    	
    	$albums=DB::select($sql,$where);
    	//il primo parametro è il nome della view che automaticamente è albums.blade.php
    	//però dobbiamo andare a prenderlo dalla cartella
    	return view('albums.albums',['title'=>'Pagina Album','albums'=>$albums]);
    	
    	
    }
    
    //FUNZIONE DI CANCELLAZIONE
    public function delete($id){
    	
    	$sql="DELETE from albums where id=:id";
    	return DB::delete($sql,['id'=>$id]); //se tutto va bene ritorna 1
    	//return redirect()->back();
    }
    
    //FUNZIONE DI VISUALIZZAZIONE
    public function show($id){
    	 
    	$sql="SELECT * from albums where id=:id";
    	return DB::select($sql,['id'=>$id]); //se tutto va bene ritorna 1
    	//return redirect()->back();
    }
    
    //FUNZIONE DI UPDATE
    public function edit($id){
    
    	$sql="SELECT id,album_name, description from albums where id=:id";
    	$album=DB::select($sql,['id'=>$id]);
    
    	return view('albums.edit',['album'=>$album[0],'title'=>'Pagina Edit Album']);
    }
    
    public function store($id,Request $req){
    	$data = request()->only(['name','description']);
    	
    	$data['id']=$id;
    	
    	$sql="UPDATE albums set album_name=:name, description=:description";
    	$sql.=' WHERE id=:id';
 
    	$res=DB::update($sql,$data);
    	
    	dd($res);
    }
    
}