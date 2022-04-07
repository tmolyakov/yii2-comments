<?php

declare(strict_types=1);

namespace app\models\entities\user;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $login
 *
 * Class User
 * @package app\models\entities\user
 */
class User extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['id', 'login'], RequiredValidator::class],
            [['id'], NumberValidator::class],
            ['login', StringValidator::class, 'min' => 3, 'max' => 255],
        ];
    }

    /**
     * @return UserQuery
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }
}