<?php

declare(strict_types=1);

namespace app\models\form;

use yii\base\Model;
use yii\validators\NumberValidator;
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
    /** @var int */
    public $commentId;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['text', 'postId', 'authorId'], RequiredValidator::class],
            [['commentId', 'postId', 'authorId', 'parentId'], NumberValidator::class],
            ['text', StringValidator::class, 'min' => 2, 'max' => 65535],
        ];
    }
}