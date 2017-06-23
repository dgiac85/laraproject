<?php


use Carbon\Carbon;
use App\User;
use Illuminate\Database\Seeder;

class SeedUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//creo 30 utenti randominci
    	$users=factory(App\User::class,30)->create(); //fn + f2 per fare il focus
    	

		/*
		$sql='INSERT INTO users (name,email,password,created_at) values (:name,:email,:password,:created_at)';

		for ($i=0; $i<31; $i++){
			//Carbon libreria di gestione date
	        	//in alternativa date('Y-m-d H:i:s')
	        DB::statement($sql,[
	        	'name' => 'Giacomo'.$i,
	        	'email' => 'giacomo'.$i.'@gmail.com',
	        	'password' => bcrypt('s3cr3t'),
	        	'created_at' => Carbon::now(), 	        	
	        ]);
    	}
    	*/
    }
}
