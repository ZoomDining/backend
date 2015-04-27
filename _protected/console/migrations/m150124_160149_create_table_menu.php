<?php

use yii\db\Schema;
use yii\db\Migration;

class m150124_160149_create_table_menu extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu}}', [
            'id'            => Schema::TYPE_PK,
            'name'          => Schema::TYPE_STRING . '(512)  NOT NULL',
            'price'         => Schema::TYPE_STRING . '(64) NOT NULL',
            'description'   => Schema::TYPE_TEXT . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%menu}}');
    }
}
