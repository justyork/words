<?php

use yii\db\Migration;

/**
 * Class m190922_094810_add_users_id_to_word
 */
class m190922_094810_add_users_id_to_word extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('word', 'user_id', $this->integer());
        $this->addColumn('word_category', 'user_id', $this->integer());
        $this->addColumn('word_pack', 'user_id', $this->integer());

        $this->addForeignKey('idx-word-user_id',
            'word',
            'user_id',
            'user',
            'id'
        );
        $this->addForeignKey('idx-word_category-user_id',
            'word_category',
            'user_id',
            'user',
            'id'
        );
        $this->addForeignKey('idx-word_pack-user_id',
            'word_pack',
            'user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('idx-word-user_id', 'word');
        $this->dropForeignKey('idx-word_category-user_id', 'word_category');
        $this->dropForeignKey('idx-word_pack-user_id', 'word_pack');
         $this->dropColumn('word', 'user_id');
         $this->dropColumn('word_category', 'user_id');
         $this->dropColumn('word_pack', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190922_094810_add_users_id_to_word cannot be reverted.\n";

        return false;
    }
    */
}
