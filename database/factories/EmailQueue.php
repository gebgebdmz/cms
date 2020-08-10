<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EmailQueue;
use Faker\Generator as Faker;

$factory->define(EmailQueue::class, function (Faker $faker) {
    return [
        'destination_email' => $faker -> safeEmail,
        'email_body' => $faker->regexify('[A-Za-z0-9]{20}'),
        'email_subject' => $faker->regexify('[A-Za-z0-9]{20}'),
        'created_at' => now(),
        'is_processed' => 0
    ];
});
