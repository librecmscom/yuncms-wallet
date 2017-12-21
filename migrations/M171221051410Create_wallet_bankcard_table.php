<?php

namespace yuncms\wallet\migrations;

use yii\db\Migration;

class M171221051410Create_wallet_bankcard_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%wallet_bankcard}}', [
            'id' => $this->primaryKey()->unsigned()->comment('Id'),
            'user_id' => $this->integer()->unsigned()->comment('User Id'),
            'bank' => $this->string(100)->comment('银行名称'),
            'city' => $this->string(50)->comment('开户城市'),
            'username' => $this->string(50)->comment('开户名'),
            'name' => $this->string(50)->comment('开户行'),
            'number' => $this->string(30)->comment('银行卡号'),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('{{%wallet_bankcard_fk_1}}', '{{%wallet_bankcard}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function safeDown()
    {
        $this->dropTable('{{%wallet_bankcard}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171221051410Create_bankcard_table cannot be reverted.\n";

        return false;
    }
    */
}
