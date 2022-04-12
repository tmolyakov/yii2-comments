<?php

namespace app\models\entities\comment;

/**
 * Class CommentViewDto
 * @package app\models\entities\comment
 */
class CommentViewDto
{
    /** @var array */
    public $relations;
    /** @var array */
    public $commentsData;
    /** @var array */
    public $topIds;

    /**
     * CommentViewDto constructor.
     * @param array $relations
     * @param array $commentsData
     * @param array $topIds
     */
    public function __construct(array $relations, array $commentsData, array $topIds)
    {
        $this->relations = $relations;
        $this->commentsData = $commentsData;
        $this->topIds = $topIds;
    }
}