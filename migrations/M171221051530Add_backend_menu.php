<?php

namespace yuncms\wallet\migrations;

use yii\db\Migration;
use yii\db\Query;

class M171221051530Add_backend_menu extends Migration
{

    public function safeUp()
    {
        $this->insert('{{%admin_menu}}', [
            'name' => '银行卡管理',
            'parent' => 7,
            'route' => '/wallet/bankcard/index',
            'icon' => 'fa-credit-card',
            'sort' => NULL,
            'data' => NULL
        ]);
        $id = (new Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '银行卡管理', 'parent' => 7])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['更新银行卡', $id, '/wallet/bankcard/view', 0, NULL],
        ]);

        $this->insert('{{%admin_menu}}', [
            'name' => '钱包管理',
            'parent' => 7,
            'route' => '/wallet/wallet/index',
            'icon' => 'fa-dollar',
            'sort' => NULL,
            'data' => NULL
        ]);

        $id = (new Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '钱包管理', 'parent' => 7])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['创建钱包', $id, '/wallet/wallet/create', 0, NULL],
            ['更新钱包', $id, '/wallet/wallet/update', 0, NULL],
            ['查看钱包', $id, '/wallet/wallet/view', 0, NULL],
            ['充值', $id, '/wallet/wallet/recharge', 0, NULL],
        ]);

        $this->insert('{{%admin_menu}}', [
            'name' => '提现管理',
            'parent' => 7,
            'route' => '/wallet/withdrawals/index',
            'icon' => 'fa-money',
            'sort' => NULL,
            'data' => NULL
        ]);

        $id = (new Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '提现管理', 'parent' => 7])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['添加提现', $id, '/wallet/withdrawals/create', 0, NULL],
            ['更新提现', $id, '/wallet/withdrawals/update', 0, NULL],
            ['查看提现', $id, '/wallet/withdrawals/view', 0, NULL],
        ]);

    }

    public function safeDown()
    {
        $id = (new Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '银行卡管理', 'parent' => 7])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);

        $id = (new Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '钱包管理', 'parent' => 7])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);

        $id = (new Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '提现管理', 'parent' => 7])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171221051530Add_backend_menu cannot be reverted.\n";

        return false;
    }
    */
}
