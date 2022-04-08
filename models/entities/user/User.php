<?php

declare(strict_types=1);

namespace app\models\entities\user;

use yii\db\ActiveRecord;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 *
 * Class User
 * @package app\models\entities\user
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint(20)]
 * @property int $TOTAL_CONNECTIONS [bigint(20)]
 * @property int $id [int(11)]
 * @property string $login [varchar(255)]
 * @property bool $deleted [tinyint(1)]
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

    public function rules(): array
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