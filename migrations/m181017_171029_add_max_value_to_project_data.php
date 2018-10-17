<?php

use yii\db\Migration;

/**
 * Class m181017_171029_add_max_value_to_project_data
 */
class m181017_171029_add_max_value_to_project_data extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%project_data}}', 'max_value', $this->smallInteger()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%project_data}}', 'max_value');
        echo "m181017_171029_add_max_value_to_project_data are reverted.\n";

        return true;
    }

}
