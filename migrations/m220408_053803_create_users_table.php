<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m220408_053803_create_users_table extends Migration
{
    /** @var string */
    private $tableName = 'users';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->notNull(),
            'deleted' => $this->boolean()->notNull()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx_users_login',
            $this->tableName,
            'login',
            true
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
