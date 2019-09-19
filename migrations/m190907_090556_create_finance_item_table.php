<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%finance_item}}`.
 */
class m190907_090556_create_finance_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%finance_item}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'cost' => $this->double(),
            'date' => $this->integer(),
        ]);

        $this->addForeignKey(
            'idx-finance_item-category_id',
            'finance_item',
            'category_id',
            'finance_category',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%finance_item}}');
    }
}
