<?php

use yii\db\Migration;

/**
 * Handles the creation of table `config`.
 */
class m190911_140717_create_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('config', [
            'id' => $this->primaryKey(),
            'group' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(),
            'value' => $this->text(),
            'type' => $this->integer(),
            'params' => $this->text(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('config');
    }
}
