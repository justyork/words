<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word_info}}`.
 */
class m190911_013143_create_word_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%word_info}}', [
            'id' => $this->primaryKey(),
            'ab_view' => $this->integer(),
            'ab_correct' => $this->integer(),
            'ba_view' => $this->integer(),
            'ba_correct' => $this->integer(),
            'random_view' => $this->integer(),
            'random_correct' => $this->integer(),
            'ab_last' => $this->integer(),
            'ba_last' => $this->integer(),
            'random_last' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%word_info}}');
    }
}
