<?php

namespace tests\unit\fixtures;

use yii\test\ActiveFixture;

/**
 * Class UserFixture
 * @package fixtures
 */
class UserFixture extends ActiveFixture
{
    /** @var string */
    public $modelClass = 'app\models\entities\user\User';
}