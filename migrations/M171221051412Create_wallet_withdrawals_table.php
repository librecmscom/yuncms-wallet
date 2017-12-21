<?php

namespace yuncms\wallet\migrations;

use yii\db\Migration;

class M171221051412Create_wallet_withdrawals_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%wallet_withdrawals}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'bankcard_id' => $this->integer()->unsigned()->comment('银行卡关系'),
            'currency' => $this->string(10)->notNull()->comment('币种'),
            'money' => $this->decimal(10, 2)->defaultValue(0.00),
            'status' => $this->smallInteger(1)->defaultValue(0)->comment('状态'),
            'confirmed_at' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('{{%withdrawals_fk_1}}', '{{%wallet_withdrawals}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%withdrawals_fk_2}}', '{{%wallet_withdrawals}}', 'bankcard_id', '{{%wallet_bankcard}}', 'id', 'CASCADE', 'RESTRICT');


    }

    public function safeDown()
    {
        $this->dropTable('{{%wallet_withdrawals}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171221051412Create_wallet_withdrawals_table cannot be reverted.\n";

        return false;
    }
    */
}
