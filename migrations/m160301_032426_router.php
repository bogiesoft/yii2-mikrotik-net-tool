<?php

use yii\db\Migration;

class m160301_032426_router extends Migration
{
    public function up()
    {
        $this->createTable('router',[
            'id' => $this->primarykey(),
            'name' => $this->string(20),
            'host' => $this->string(15),
            'port' => $this->integer(5),
            'user' => $this->string(300),
            'pass' => $this->string(300),
            'src_address' => $this->string(20),
        ]);
    }

    public function down()
    {
        $this->dropTable('router');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
