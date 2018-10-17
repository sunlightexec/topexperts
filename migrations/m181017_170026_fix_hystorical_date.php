<?php

use yii\db\Migration;

/**
 * Class m181017_170026_fix_hystorical_date
 */
class m181017_170026_fix_hystorical_date extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('{{%hystorical_data}}', 'project_id', $this->integer());

        $this->dropForeignKey('fk-hystorical_data-project_id',
            '{{%hystorical_data}}');

        $this->addForeignKey(
            'fk-hystorical_data-project_id',
            '{{%hystorical_data}}',
            'project_id',
            '{{%projects}}',
            'id',
            'SET NULL'
        );
    }

    public function down()
    {
        echo "m181017_170026_fix_hystorical_date cannot be reverted.\n";

        return false;
    }

}
