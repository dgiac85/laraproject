<?php

use Illuminate\Database\Seeder;
use App\Models\Photo;

class SeedPhotoTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 
    	//creo 30 utenti randominci
    	$photos=factory(App\Models\Photo::class,200)->create();
    }
}
