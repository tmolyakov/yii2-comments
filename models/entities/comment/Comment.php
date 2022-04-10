<?php

declare(strict_types=1);

namespace app\models\entities\comment;

use app\models\entities\user\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 *
 * Class Comment
 * @package app\models\entities\comment
 * @property int $id [int(11)]
 * @property int $post_id [int(11)]
 * @property int $author_id [int(11)]
 * @property int $parent_id [int(11)]
 * @property int $created_at [timestamp]
 * @property int $updated_at [timestamp]
 * @property string $text
 * @property bool $deleted [tinyint(1)]
 *
 * @property User $author
 */
class Comment extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'comments';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                ['post_id', 'author_id'],
                RequiredValidator::class
            ],
            [
                ['id', 'post_id', 'author_id', 'parent_id', 'created_at', 'updated_at'],
                NumberValidator::class
            ],
            ['text', StringValidator::class, 'min' => 2, 'max' => 65535],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @return CommentQuery
     */
    public static function find(): CommentQuery
    {
        return new CommentQuery(get_called_class());
    }
}