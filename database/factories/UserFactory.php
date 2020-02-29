<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Persistence\Model\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(\App\Persistence\Model\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'article' => $faker->text(),
        'title_clean' => $faker->unique()->title,
        'date_published' => $faker->dateTime,
        'banner_image' => $faker->imageUrl(),
        'featured' => $faker->boolean(),
        'enabled' => $faker->boolean(),
        'comments_enabled' => $faker->boolean(),
        'view' => $faker->numberBetween(),
    ];
});

$factory->define(\App\Persistence\Model\Comment::class, function (Faker $faker) {
   return [
       'comment' => $faker->text(),
       'is_reply_to' => 0,
       'enabled' => $faker->boolean(),
       'date' => $faker->dateTime,
   ];
});

$factory->define(\App\Persistence\Model\Author::class, function (Faker $faker) {
    return [
        'display_name' => $faker->unique()->userName,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
    ];
});

$factory->define(\App\Persistence\Model\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->text(45),
        'name_clean' => $faker->unique()->text(45),
        'enabled' => $faker->boolean(),
        //'created_at' => $faker->dateTime,
    ];
});

$factory->define(\App\Persistence\Model\Tag::class, function (Faker $faker) {
    return [
        'tag' => $faker->text(45),
        'tag_clean' => $faker->unique()->text(45),
    ];
});
