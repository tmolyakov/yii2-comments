<?php

declare(strict_types=1);

namespace app\services;

use app\models\entities\comment\Comment;
use app\models\entities\comment\CommentViewDto;
use app\models\form\CommentForm;
use Exception;
use yii\db\StaleObjectException;

/**
 * Class CommentService
 * @package app\services
 */
class CommentService
{
    const COMMENT_DEPTH = 3;

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
        Comment::deleteAll(['parent_id' => $commentId]);

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

    /**
     * @param array $topIds
     * @return array
     */
    public static function getRelations(array $topIds): array
    {
        $commentsRelations = [];

        foreach ($topIds as $id) {
            $commentsRelations[$id] = [];
        }

        for ($i = 1; $i <= self::COMMENT_DEPTH; $i++) {
            $children = Comment::find()
                ->getChildren($topIds)
                ->select(['id', 'parent_id', 'text'])
                ->asArray()
                ->all();

            if (empty($children)) {
                break;
            }

            $topIds = [];

            foreach ($children as $child) {
                $commentsRelations[$child['parent_id']][$child['id']] = $child;
                $topIds[] = $child['id'];
            }
        }

        return $commentsRelations;
    }

    /**
     * @return CommentViewDto
     */
    public static function getViewData(): CommentViewDto
    {
        $topIds = Comment::find()->getTop()->select('id')->column();
        $relations = self::getRelations($topIds);
        $allIds = array_keys($relations);

        foreach ($relations as $items) {
            $allIds = array_merge($allIds, array_keys($items));
        }

        /** @var Comment[] $comments */
        $comments = Comment::find()->byIds(array_unique($allIds))->all();
        $commentsData = [];

        foreach ($comments as $comment) {
            $commentsData[$comment->id] = $comment;
        }

        return new CommentViewDto($relations, $commentsData, $topIds);
    }
}