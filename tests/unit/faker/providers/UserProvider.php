<?php

namespace tests\unit\faker\providers;

use Faker\Provider\Base;

/**
 * Class UserProvider
 * @package tests\unit\faker\providers
 */
class UserProvider extends Base
{
    public function userData(): array
    {
        return [
            'login' => $this->generator->text(20)
        ];
    }
}