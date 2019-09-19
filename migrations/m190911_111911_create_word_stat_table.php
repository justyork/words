<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word_stat}}`.
 */
class m190911_111911_create_word_stat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%word_stat}}', [
            'id' => $this->primaryKey(),
            'count_words' => $this->integer(),
            'date' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%word_stat}}');
    }
}
