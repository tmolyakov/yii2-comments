<?php

declare(strict_types=1);

namespace app\models\entities\comment;

use yii\db\ActiveQuery;

/**
 * Class CommentQuery
 * @package app\models\entities\comment
 */
class CommentQuery extends ActiveQuery
{
    /**
     * @param int $id
     * @return CommentQuery
     */
    public function byId(int $id): CommentQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param int[] $ids
     * @return CommentQuery
     */
    public function byIds(array $ids): CommentQuery
    {
        return $this->andWhere(['id' => $ids]);
    }

    /**
     * @param int $id
     * @return CommentQuery
     */
    public function byParentId(int $id): CommentQuery
    {
        return $this->andWhere(['parent_id' => $id]);
    }

    /**
     * @return CommentQuery
     */
    public function getAllWithAuthor(): CommentQuery
    {
        return $this->with('author');
    }

    /**
     * @return CommentQuery
     */
    public function getTop(): CommentQuery
    {
        return $this->andWhere(['parent_id' => 0]);
    }

    /**
     * @param int[] $ids
     * @return CommentQuery
     */
    public function getChildren(array $ids): CommentQuery
    {
        return $this->andWhere(['parent_id' => $ids]);
    }

    /**
     * @return CommentQuery
     */
    public function active(): CommentQuery
    {
        return $this->andWhere(['deleted' => 0]);
    }
}