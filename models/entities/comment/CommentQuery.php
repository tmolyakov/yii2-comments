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
     * @return CommentQuery
     */
    public function getAllWithAuthor(): CommentQuery
    {
        return $this->active()->with('author');
    }

    /**
     * @return CommentQuery
     */
    public function active(): CommentQuery
    {
        return $this->andWhere(['deleted' => 0]);
    }
}