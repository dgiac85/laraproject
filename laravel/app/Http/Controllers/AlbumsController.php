<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class AlbumsController extends Controller
{
    //index
    public function index(Request $request){
    	
    	/*GREZZE$sql='select * from albums where 1=1'; //si ritorna 1=1 nel caso non si passano valori
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
    	$sql.=' ORDER BY id desc';
    	//IMPORTANTE FILTRARE I DATI IN ARRIVO ALLA GET in modo da non avere SQL INJECTION
    	//dd($sql); //il dump ferma la query
    	
    	//al posto di array_values si può usare con i segnaposto :id o :album_name soltanto $where
    	//return DB::select($sql,$where);
    	//DB è una facade;
    	//return DB::select($sql,array_values($where)); //il select ci invia un array di record è ogni record è una stdClass che rappresenta una riga della tabella
    	
    	$albums=DB::select($sql,$where);
    	//il primo parametro è il nome della view che automaticamente è albums.blade.php
    	//però dobbiamo andare a prenderlo dalla cartella
    	return view('albums.albums',['title'=>'Pagina Album','albums'=>$albums]);*/
    	
    	//#####################################################################
    	//utilizziamo il query builder
    	//usiamo la facade DB
    	
    	//$queryBuilder=DB::table('albums')->orderBy('id','DESC');
    	//con eloquent //withCount fa il conteggio delle photo associate all album mediante la relazione hasmany (vedi il Model album)
    	$queryBuilder=Album::orderBy('id','DESC')->withCount('photos');
    	if ($request->has('id')){
    		$queryBuilder->where('id','=',$request->input('id'));
    	}
    	if ($request->has('album_name')){
    		$queryBuilder->where('album_name','like','%'.$request->input('album_name').'%');
    	}
    	
    	$albums=$queryBuilder->get();
    	//dd($albums);
    	
    	return view('albums.albums',['title'=>'Pagina Album','albums'=>$albums]);
    	
    }
    
    //FUNZIONE DI CANCELLAZIONE
    public function delete(Album $album){
    	
    	
    	/*GREZZE$sql="DELETE from albums where id=:id";
    	return DB::delete($sql,['id'=>$id]); //se tutto va bene ritorna 1
    	//return redirect()->back();
    	*/
    	
    	//#####################################################################
    	//utilizziamo il query builder
    	//usiamo la facade DB
    	 
    	//$res=DB::table('albums')->where('id',$id)->delete(); //ricorda è una chiamata ad un metodo statico
    	//#############################################################Eloquent metodo1
    	//$res=Album::where('id',$id)->delete();
    	//############################################################Eloquent metodo 2
    	//$res=Album::find($id)->delete();
    	
    	//return ''.$res; //ritorniamo un valore di tipo stringa
    	
    	// cancellazionde anche da storage
    	$thumbNail = $album->album_thumb;
    	$disk = config('filesystems.default');
    	 
    	$res = $album->delete(); //prima cancella e poi fa la cancellazione dell'immagine dallo storage
    	if($res){
    		if($thumbNail && Storage::disk($disk)->has($thumbNail))   {
    			Storage::disk($disk)->delete($thumbNail);
    		}
    	}
    	return '' . $res;
    }
    
    //FUNZIONE DI VISUALIZZAZIONE
    public function show($id){
    	 
    	$sql="SELECT * from albums where id=:id";
    	return DB::select($sql,['id'=>$id]); //se tutto va bene ritorna 1
    	//return redirect()->back();
    }
    
    //FUNZIONE DI UPDATE
    public function edit($id){
    
    	/*$sql="SELECT id,album_name, description from albums where id=:id";
    	$album=DB::select($sql,['id'=>$id]);
    	return view('albums.edit',['album'=>$album[0],'title'=>'Pagina Edit Album']);
    	*/
    	
    	//con Eloquent
    	$album=Album::find($id);
    	
    	//dd($album->album_thumb);
    	return view('albums.edit',['album'=>$album,'title'=>'Pagina Edit Album']);
    }
    
    public function create(){
    	$album=new Album();
    	
    	return view('albums.createalbum',['title'=>'Pagina Create Album', 'album'=>$album]);
    }
    
    public function save(){ //INSERISCE NUOVO
    	$data= request()->only(['name','description']); 
    	/*$data['user_id']=1; 
    	$sql='INSERT INTO albums (album_name,description,user_id)';
    	$sql.=' VALUES(:name, :description, :user_id)';
    	
    	$res=DB::insert($sql,$data);
    	
    	*/
    	//#####################################################################
    	//utilizziamo il query builder
    	//usiamo la facade DB
    	
    	//$res = DB::table('albums')->insert(
    	//eloquent
    	//eloquent metodo 1 senza usare $fillable
    	/*$res=Album::insert(
    			[
    					'album_name'=>request()->input('name'),
    					'description'=>request()->input('description'),
    					'user_id'=> 1 //fino all'autenticazione
    			]
    	); //si potrebbe passare anche un array di array per inserire diversi record*/
    		
    	//eleoquent metodo 2 utilizzando il fillable
    	/*$res=Album::create( //bisogna dire nel model quali sono i valori $fillable
    			[
    					'album_name'=>request()->input('name'),
    					'description'=>request()->input('description'),
    					'user_id'=> 1 //fino all'autenticazione
    			]
    			); //si potrebbe passare anche un array di array per inserire diversi record*/
    	
    	$album=new Album();
    	$album->album_name=request()->input('name');
    	$album->description=request()->input('description');
    	$album->album_thumb='';
    	$album->user_id=1;

    	$res=$album->save();
    	
    	if($res){
    		if($this->processFile($album->id,request(),$album)){
    			$album->save();
    		}
    	}
    	
    	$messaggio = $res ? 'Album '.$data['name'].' creato!':'Album '.$data['name'].' non creato!';
    	session()->flash('message',$messaggio);
    	return redirect()->route('albums'); //è una response non è una redirect vera e propria
    }
    
    
    public function processFile($id,Request $req,&$album){ //album è passato per riferimento
    	if (!$req->hasFile('album_thumb')){
    		return false;
    	}
    	//if ($req->hasFile('album_thumb')){
    		$file=$req->file('album_thumb');
    		//il metodo store torna una stringa che è il nome del file. 'public' indica la cartella dove memorizzare le immagini
    		//$fileName=$file->store(env('ALBUM_THUMB_DIR'),'public'); //punta a storage/images/album_thumbs l'helper env mi permette di fare questo //PRIMO METODO
    		if(!$file->isValid()){
    			return false;
    		}
    			$fileName=$id.'.'.$file->extension();
    			$file->storeAs(env('ALBUM_THUMB_DIR'),$fileName);
    			 
    			//$album->album_thumb=$fileName;
    			$album->album_thumb = env('ALBUM_THUMB_DIR') . $fileName;
    			//dd($album->album_thumb);
    		//}
    		return true; //CI STA UN FILE ALLEGATO QUINDI PROCESSFILE DEVE INVIARE TRUE
    	
    	//}
    }
    
    public function store($id,Request $req){ //SALVA MOD
    	/*$data = request()->only(['name','description']);
    	
    	$data['id']=$id;
    	
    	$sql="UPDATE albums set album_name=:name, description=:description";
    	$sql.=' WHERE id=:id';
 
    	$res=DB::update($sql,$data);
    	*/
    	//#####################################################################
    	//utilizziamo il query builder
    	//usiamo la facade DB
    	
    	//$res = DB::table('albums')->where('id',$id)->update(
    	//eloquent metodo1
    	/*$res=Album::where('id',$id)->update(
    		[
    				'album_name'=>request()->input('name'),
    				'description'=>request()->input('description')
    		]		
    	);*/
    	//eloquent metodo 2 con find
    	$album=Album::find($id);
    	$album->album_name=request()->input('name');
    	$album->description=request()->input('description');
    	$album->user_id=1;
    	
    	$this->processFile($id,$req,$album);
    	
    	$res=$album->save();
    	
    	$messaggio = $res ? 'Album con id '.$id.' aggiornato!':'Album con id '.$id.' non aggiornato!'; 
    	session()->flash('message',$messaggio);
    	return redirect()->route('albums'); //è una response non è una redirect vera e propria
    }
    
    public function getImages(Album $album){
    	$images = Photo::where('album_id',$album->id )->get();//latest()->paginate(env('IMG_PER_PAGE'));
    	//$images=  $album->photos;
    
    	return view('images.albumimages',compact('album','images'));
    	 
    }
    
}

