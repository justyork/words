<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%word_pack}}`.
 */
class m190911_115813_create_word_pack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%word_pack}}', [
            'id' => $this->primaryKey(),
            'items' => $this->text(),
            'date' => $this->integer(),
            'category_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%word_pack}}');
    }
}
