<?php

use Illuminate\Database\Seeder;
use App\Models\Album;

class SeedAlbumTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 
    	//creo 30 utenti randomici
    	$albums=factory(App\Models\Album::class,10)->create(); //fn + f2 per fare il focus
    }
}