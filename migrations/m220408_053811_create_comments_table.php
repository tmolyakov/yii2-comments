<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m220408_053811_create_comments_table extends Migration
{
    /** @var string */
    private $tableName = 'comments';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(11)->notNull(),
            'author_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'text' => $this->text(),
            'deleted' => $this->boolean()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk_comments_author_id',
            $this->tableName,
            'author_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx_comments_post_id',
            $this->tableName,
            'post_id'
        );

        $this->createIndex(
            'idx_comments_parent_id',
            $this->tableName,
            'parent_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
