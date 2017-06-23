<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

class PageController extends Controller
{

	protected $data=[
		[
			'name' => 'Hidran',
			'lastname' => 'Arias'
		],
		[
			'name' => 'Giacomo',
			'lastname' => 'Delfini'
		],
		[
			'name' => 'Harry',
			'lastname' => 'Potter'
		]
	];
    //il seguente metodo mapperà la view about
    public function about(){

    	//In foundation/Application ci sono gli helper e le facade più importatne

    	//il metodo view è sostanzialmente un helper
    	
    	return view('about'); //return View::make('about'); //usa la facade per chiamare staticamente il metodo make utile a fare la view

    	//altro metodo con helper app
    	//$view = app('view');
    	//return $view('about');
    }

    public function blog(){
        //passo un array utile ad usare la direttiva @include di blade
        $title="Pagina di Blog";

    	return view('blog',
            [
                'title' => $title,
                'img_title' => 'Title',
                'img_url' => 'http://lorempixel.com/400/200',
                'slot' => ''
            ]);

        //se non mettiamo la variabile slot la direttiva include si rompe...queste variabili sono globali
    }

     public function staff(){
    	//PRIMO METODO
        /*return view('staff', 
    		[
    			'title' => 'Il nostro staff', 
    			'staff'=> $this->data
    		]);*/

         //SECONDO METODO
         /*further method
            return view('staff')->withStaff($this->data)->withTitle('Our staff');
         */  

         //TERZO METODO
         //utilizzo della funzione compact
         $staff=$this->data;
         $title="our staff";
         return view('staff',compact('title','staff'));//compact crea un array associativo cercando come dati quelle parole chiave 

        //QUARTO METODO
    	/*return view('staff')
    		->with('staff', $this->data)
    		->with('title', 'Our staff');*/
    	
    } //chiusura metodo staff

    public function staffb(){
        //PRIMO METODO
        /*return view('staff', 
            [
                'title' => 'Il nostro staff', 
                'staff'=> $this->data
            ]);*/

         //SECONDO METODO
         /*further method
            return view('staff')->withStaff($this->data)->withTitle('Our staff');
         */  

         //TERZO METODO
         //utilizzo della funzione compact
         $staff=$this->data;
         $stafforelse=$this->data;
         $title="our staffb";
         //var_dump(compact('title','staff','stafforelse'));
         return view('staffb',compact('title','staff','stafforelse'));//compact crea un array associativo cercando come dati quelle parole chiave 

        //QUARTO METODO
        /*return view('staff')
            ->with('staff', $this->data)
            ->with('title', 'Our staff');*/
        
    } //chiusura metodo staff
}
