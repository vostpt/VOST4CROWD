<?php
declare(strict_types=1);

use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/** @var Factory $factory */
$factory->define(Project::class, function (Faker $faker) {

    $data = [
        'title'       => $faker->name(),
        'description' => $faker->sentence(),
        'icon'        => null,
        'fields'      => [],
    ];

    for ($i = 0; $i <= 4; $i++) {
        $name = $faker->sentence(2);

        $data['fields'][] = [
            'label'    => $name,
            'name'     => Str::snake($name),
            'nullable' => $faker->boolean(),
            'type'     => $faker->randomElement(Project::$fieldsTypesList),
            'icon'     => null,
        ];
    }

    return $data;
});
