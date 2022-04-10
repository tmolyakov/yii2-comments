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
     * @return ActiveQuery
     */
    public function getAllWithAuthor(): ActiveQuery
    {
        return $this->active()->with('author');
    }

    /**
     * @return ActiveQuery
     */
    public function active(): ActiveQuery
    {
        return $this->andWhere(['deleted' => 0]);
    }
}