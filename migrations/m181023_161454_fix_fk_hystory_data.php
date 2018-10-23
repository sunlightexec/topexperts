<?php

use yii\db\Migration;

/**
 * Class m181023_161454_fix_fk_hystory_data
 */
class m181023_161454_fix_fk_hystory_data extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->dropForeignKey('fk-hystorical_data-currency_id', 'hystorical_data');
        $this->addForeignKey(
            'fk-hystorical_data-currency_id',
            'hystorical_data',
            'currency_id',
            'currencies',
            'id',
            'SET NULL',
            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-hystorical_data-currency_id', 'hystorical_data');
        $this->addForeignKey(
            'fk-hystorical_data-currency_id',
            'hystorical_data',
            'currency_id',
            'currencies',
            'id',
            'SET NULL'
        );

        echo "m181023_161454_fix_fk_hystory_data are reverted.\n";

        return true;
    }

}
