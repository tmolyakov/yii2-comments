<?php

/**
 * @var $faker \Faker\Generator
 */

use tests\unit\faker\providers\UserProvider;

$faker->addProvider(new UserProvider($faker));

return $faker->userData;