<?php

declare(strict_types=1);

namespace app\models\entities\comment\form;

use yii\base\Model;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class CommentForm
 * @package app\models\entities\comment\form
 */
class CommentForm extends Model
{
    /** @var string */
    public $text;
    /** @var int */
    public $postId;
    /** @var int */
    public $authorId;
    /** @var int */
    public $parentId = 0;

    /**
     * @return array|array[]
     */
    public function rules(): array
    {
        return [
            [['text', 'postId', 'authorId'], RequiredValidator::class],
            ['text', StringValidator::class, 'min' => 2, 'max' => 65535],
        ];
    }
}