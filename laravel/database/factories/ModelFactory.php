<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\User;
use App\Models\Album;
use App\Models\Photo;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Album::class, function (Faker\Generator $faker) {

	return [
			'album_name' => $faker->name,
			'description' => $faker->text(128),
			'user_id' => User::inRandomOrder()->first()->id, //inRandomOrder() si chiama staticamente. è un metodo statico che ha accesso al query builder. Il query builder poi ritorna il Singleton utile a chiamare i metodi
	];
});

$factory->define(App\Models\Photo::class, function (Faker\Generator $faker) {
	$values=[
		'abstract',
		'animals',
		'business',
		'cats',
		'city',
		'technics',
		'sports',
	    'transport',			
	];

	return [
			'album_id' => Album::inRandomOrder()->first()->id,
			'name' => $faker->text(64),
			'description'=>$faker->text(128),
			'img_path'=>$faker->imageUrl(640,480,$faker->randomElement($values)),
			
	];
});