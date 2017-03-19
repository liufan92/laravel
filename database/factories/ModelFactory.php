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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->word,
        'dob' => Carbon\Carbon::parse('July 28 1992'),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {

    return [
    	'user_id' => App\User::all()->random()->id,
    	'content' => $faker->paragraph(5), //Generate paragraph with 5 sentences
        'live' => $faker->boolean(), //boolean(70) gives 70% of getting true
        'post_on' => Carbon\Carbon::parse('+1 week'),     
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {

    return [
        'user_id' => App\User::all()->random()->id,
        'article_id' => App\Article::all()->random()->id,
        'text' => $faker->paragraph(1),
    ];
});
