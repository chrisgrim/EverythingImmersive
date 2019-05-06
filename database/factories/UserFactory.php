<?php

use Faker\Generator as Faker;
use App\Event;
use App\Organizer;
use App\Category;

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

$factory->define(App\User::class, function (Faker $faker) {
    $imagesave = $faker->image('public/storage/avatars',100,100, null, false);
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'avatar_path' => 'avatars/'. $imagesave,
        'image_path' => 'avatars/'. $imagesave,
    ];
});
$factory->define(App\Region::class, function (Faker $faker) {
    return [
        'region' => $faker->name,
    ];
});

$factory->define(App\Genre::class, function (Faker $faker) {
    return [
        'genre' => $faker->name,
    ];
});

$factory->define(App\ContactLevel::class, function (Faker $faker) {
    return [
        'level' => $faker->name,
    ];
});

$factory->define(App\Organizer::class, function (Faker $faker) {
    $imagesave = $faker->image('public/storage/organizers',100,100, null, false);
    $name = $faker->company;
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'organizationName' => $name,
        'slug' => str_slug($name),
        'organizationDescription' => $faker->paragraph,
        'instagramHandle' => '@'. $name,
        'facebookHandle' => '@'. $name,
        'twitterHandle' => '@'. $name,
        'organizationWebsite' => $faker->url,
        'organizationImagePath' => 'organizers/'. $imagesave,
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    $imagesave = $faker->image('public/storage/category',100,100, null, false);
    $title = $faker->company;
    return [
        'categoryName' => $title,
        'slug' => str_slug($title),
        'categoryDescription' => $faker->paragraph,
        'categoryImagePath' => 'category/'. $imagesave,
    ];
});

$factory->define(App\Event::class, function (Faker $faker) {
    $title = $faker->company;
    $eventimagesave = $faker->image('public/storage/event-images',1200,800, null, false);
    $thumbimagesave = $faker->image('public/storage/thumb-images',600,400, null, false);
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'organizer_id' => function () {
            return factory('App\Organizer')->create()->id;
        },
        'category_id' => function () {
            return factory('App\Category')->create()->id;
        },
        'eventTitle' => $title,
        'slug' => str_slug($title),
        'eventDescription' => $faker->paragraph,
        'eventWebsite' => $faker->url,
        'eventGeneralCost' => $faker->randomDigit,
        'eventSeniorCost' => $faker->randomDigit,
        'eventVIPCost' => $faker->randomDigit,
        'eventStudentCost' => $faker->randomDigit,
        'eventExpectations' => $faker->paragraph,
        'eventTicketUrl' => $faker->url,
    	'eventStreetAddress' => $faker->streetAddress,
    	'eventCity' => $faker->city,
    	'eventState' => $faker->state,
    	'eventCountry' => $faker->country,
    	'eventZipcode' => $faker->postcode,
        'eventLong' => $faker->randomDigit,
        'eventLat' => $faker->randomDigit,
        'ageRestriction' => $faker->randomDigit,
        'wheelchairReady' => $faker->randomElement(['Yes', 'No']),
        'sexualViolence' => $faker->randomElement(['Yes', 'No']),
        'mobilityAdvisories' => $faker->paragraph,
        'sexualViolenceDescription' => $faker->paragraph,
        'contactAdvisoryDescription' => $faker->paragraph,
        'contentAdvisories' => $faker->paragraph,
        'openingDate' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
        'closingDate' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
        'eventImagePath' => 'event-images/'. $eventimagesave,
        'thumbImagePath' => 'thumb-images/'. $thumbimagesave,
        'visitors' => $faker->randomDigit,
    ];
});
