<?php

declare(strict_types=1);

namespace app\services;

use app\models\entities\comment\Comment;
use app\models\form\CommentForm;
use Exception;
use yii\db\StaleObjectException;

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

    /**
     * @param int $commentId
     * @return bool
     * @throws StaleObjectException
     */
    public static function delete(int $commentId): bool
    {
        return (bool)Comment::find()->byId($commentId)->one()->delete();
    }

    /**
     * @param CommentForm $form
     * @return Comment
     * @throws StaleObjectException
     */
    public static function update(CommentForm $form): Comment
    {
        /** @var Comment $comment */
        $comment = Comment::find()->byId((int)$form->commentId)->one();
        $comment->text = $form->text;
        $comment->update(true, ['text']);

        return $comment;
    }
}