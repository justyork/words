<?php

use yii\db\Migration;

/**
 * Class m191026_174204_alter_word_table
 */
class m191026_174204_alter_word_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('word', 'level_ab', 'a_level');
        $this->renameColumn('word', 'level_ba', 'b_level');
        $this->renameColumn('word', 'ab_series', 'a_series');
        $this->renameColumn('word', 'ba_series', 'b_series');
        $this->renameColumn('word', 'level_ab_date', 'a_level_date');
        $this->renameColumn('word', 'level_ba_date', 'b_level_date');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('word', 'a_level', 'level_ab');
        $this->renameColumn('word', 'b_level', 'level_ba');
        $this->renameColumn('word', 'a_series', 'ab_series');
        $this->renameColumn('word', 'b_series', 'ba_series');
        $this->renameColumn('word', 'a_level_date', 'level_ab_date');
        $this->renameColumn('word', 'b_level_date', 'level_ba_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191026_174204_alter_word_table cannot be reverted.\n";

        return false;
    }
    */
}
