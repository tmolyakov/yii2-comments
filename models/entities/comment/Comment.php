<?php

declare(strict_types=1);

namespace app\models\entities\comment;

use yii\db\ActiveRecord;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;

/**
 * @property int $id
 * @property int $post_id
 * @property int $author_id
 * @property int $parent_id
 *
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $text
 *
 * Class Comment
 * @package app\models\entities\comment
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
     * @return CommentQuery
     */
    public static function find(): CommentQuery
    {
        return new CommentQuery(get_called_class());
    }
}