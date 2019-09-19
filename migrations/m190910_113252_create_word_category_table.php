<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word_category}}`.
 */
class m190910_113252_create_word_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%word_category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'last_update' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%word_category}}');
    }
}
