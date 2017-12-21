<?php

namespace yuncms\wallet\migrations;

use yii\db\Migration;

class M171221051025Create_wallet_log_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%wallet_log}}', [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'wallet_id' => $this->integer()->unsigned()->comment('Wallet Id'),
            'type' => $this->boolean()->defaultValue(false)->comment('Type'),
            'money' => $this->decimal(10, 2)->defaultValue(0.00)->comment('money'),
            'action' => $this->string(50)->comment('Action'),
            'msg' => $this->string()->comment('Msg'),
            'created_at' => $this->integer()->notNull()->unsigned()->comment('Created At')
        ], $tableOptions);

        $this->addForeignKey('{{%wallet_log_fk_1}}', '{{%wallet_log}}', 'wallet_id', '{{%wallet}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%wallet_log}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171221051025Create_wallet_log_table cannot be reverted.\n";

        return false;
    }
    */
}
