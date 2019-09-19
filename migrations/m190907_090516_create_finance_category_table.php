<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%finance_category}}`.
 */
class m190907_090516_create_finance_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%finance_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'parent_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'idx-finance_category-parent_id',
            'finance_category',
            'parent_id',
            'finance_category',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%finance_category}}');
    }
}
