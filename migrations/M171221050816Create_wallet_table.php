<?php

namespace yuncms\wallet\migrations;

use yii\db\Migration;

class M171221050816Create_wallet_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%wallet}}', [
            'id' => $this->primaryKey()->unsigned()->comment('Id'),
            'user_id' => $this->integer()->unsigned()->notNull()->comment('User Id'),
            'currency' => $this->string(10)->notNull()->comment('Currency'),
            'money' => $this->decimal(10, 2)->defaultValue(0.00)->comment(''),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Created At'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Updated At')
        ], $tableOptions);
        $this->addForeignKey('{{%wallet_fk_1}}', '{{%wallet}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%wallet}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171221050816Create_wallet_table cannot be reverted.\n";

        return false;
    }
    */
}
