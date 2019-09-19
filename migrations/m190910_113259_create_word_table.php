<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word}}`.
 */
class m190910_113259_create_word_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%word}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'word' => $this->string(),
            'translate' => $this->string(),
            'tip' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'skip' => $this->boolean(),
            'level' => $this->integer(),
            'ab_series' => $this->integer()->defaultValue(0),
            'ba_series' => $this->integer()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'idx-word-category_id',
            'word',
            'category_id',
            'word_category',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%word}}');
    }
}
