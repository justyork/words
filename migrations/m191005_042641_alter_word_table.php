<?php

use yii\db\Migration;

/**
 * Class m191005_042641_alter_word_table
 */
class m191005_042641_alter_word_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('word', 'level', 'level_ab');
        $this->addColumn('word', 'level_ba', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('word', 'level_ab', 'level');
        $this->dropColumn('word', 'level_ba');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191005_042641_alter_word_table cannot be reverted.\n";

        return false;
    }
    */
}
