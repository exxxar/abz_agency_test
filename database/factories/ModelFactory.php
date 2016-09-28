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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Personal::class, function (Faker\Generator $faker) {

    $name_w = ["Екатерина","Татьяна","Елизавета","Мариетта","Алина","Алла","Антуанэтта","Юлия"];
    $name_m = ["Алексей","Абрам","Геннадий","Иллифант","Александр","Юлиан","Адарий"];

    $sname_w = ["Вервульфовна","Крабовна","Мошталеровна","Ибрагимовна","Вассермановна","Лолитовна"];
    $sname_m = ["Адольфович","Акакиевич","Мустафаевич","Крабович","Евгеньевич","Птолемеевич"];

    $tname = ["Крабло","Дерикоза","Косоглаз","Машко", "Глазонос", "Петросян","Ашитанян","Зурбаганян","Кешикозлы"];

    $posts = ["рохля","крабчик","нащальникэ","кукушонок","гладиолус"];

    $male = (random_int(0,1)==1?
            $name_w[random_int(0, count($name_w)-1)]." ".
            $sname_w[random_int(0, count($sname_w)-1)]:
            $name_m[random_int(0, count($name_m)-1)]." ".
            $sname_m[random_int(0, count($sname_m)-1)])." ".
        $tname[random_int(0, count($tname)-1)];

  /*  $i_count = DB::table('personal')->count()==0?
        0:DB::table('personal')->count()-1;*/

    return [
        'name' => $male,
        'isWork' => random_int(0, 1),
        'lvl' => random_int(0, 10),
        'post' => $posts[random_int(0, count($posts)-1)],
        'masterId' => random_int(0,10),
        'price'=>$faker->randomFloat(10000,2000,20000),
        'startAt'=>$faker->dateTime
    ];
});
