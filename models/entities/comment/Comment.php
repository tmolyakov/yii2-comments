<?php

declare(strict_types=1);

namespace app\models\entities\comment;

use yii\behaviors\TimestampBehavior;
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
                ['id', 'post_id', 'author_id', 'created_at'],
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
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ]
        ];
    }

    /**
     * @return CommentQuery
     */
    public static function find(): CommentQuery
    {
        return new CommentQuery(get_called_class());
    }
}