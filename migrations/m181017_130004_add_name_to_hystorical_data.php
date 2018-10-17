<?php

use yii\db\Migration;

/**
 * Class m181017_130004_add_name_to_hystorical_data
 */
class m181017_130004_add_name_to_hystorical_data extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%hystorical_data}}', 'name', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%hystorical_data}}', 'name');

        echo "m181017_130004_add_name_to_hystorical_data are reverted.\n";

        return true;
    }

}
