<?php

use yii\db\Migration;

/**
 * Class m191006_152329_add_level_up_date_column
 */
class m191006_152329_add_level_up_date_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('word', 'level_ab_date', $this->integer());
        $this->addColumn('word', 'level_ba_date', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropColumn('word', 'level_up_date');
        $this->dropColumn('word', 'level_ab_date');
        $this->dropColumn('word', 'level_ba_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191006_152329_add_level_up_date_column cannot be reverted.\n";

        return false;
    }
    */
}
