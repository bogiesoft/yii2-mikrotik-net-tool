<?php

use yii\db\Migration;

class m160301_032421_user extends Migration {

    public function up() {
        $this->createTable('user', [
            'id' => $this->primarykey(),
            'username' => $this->string(100),
            'password' => $this->string(300),
            'email' => $this->string(200),
            'authKey' => $this->string(300),
            'privileges' => $this->boolean(),
        ]);
    }

    public function down() {
        $this->dropTable('user');
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
