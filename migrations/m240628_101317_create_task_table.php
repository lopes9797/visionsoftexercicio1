<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m240628_101317_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'conclusion_at' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey('fk_task_status', 'task', 'status_id', 'status', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
