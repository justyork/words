<?php

use yii\db\Migration;

/**
 * Class m191026_101241_alter_word_stat_table
 */
class m191026_101241_alter_word_stat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('word_stat', 'user_id', 'int');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('word_stat', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191026_101241_alter_word_stat_table cannot be reverted.\n";

        return false;
    }
    */
}
