<?php

declare(strict_types=1);

namespace app\services;

use app\models\entities\comment\Comment;
use app\models\entities\comment\form\CommentForm;
use Exception;
use yii\web\BadRequestHttpException;

/**
 * Class CommentService
 * @package app\services
 */
class CommentService
{
    /**
     * @param CommentForm $form
     * @return Comment
     * @throws Exception
     */
    public static function save(CommentForm $form): Comment
    {
        $comment = new Comment();
        $comment->setAttributes([
            'author_id' => $form->authorId,
            'post_id'   => $form->postId,
            'parent_id' => $form->parentId,
            'text'      => $form->text,
        ]);
        $comment->save();

        return $comment;
    }
}