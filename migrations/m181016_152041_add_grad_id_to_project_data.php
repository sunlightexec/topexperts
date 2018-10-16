<?php

use yii\db\Migration;

/**
 * Class m181016_152041_add_grad_id_to_project_data
 */
class m181016_152041_add_grad_id_to_project_data extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
//        $this->addColumn('{{%project_data}}', 'flip', $this->double()->after('graduation_id')->defaultValue(0));
//        $this->addColumn('{{%project_data}}', 'hold', $this->double()->after('flip')->defaultValue(0));

/*        $this->createIndex(
            'idx-project_data-flip',
            '{{%project_data}}',
            'flip'
        );*/

/*        $this->createIndex(
            'idx-project_data-hold',
            '{{%project_data}}',
            'hold'
        );*/

    }

    public function down()
    {

        $this->dropIndex('idx-project_data-flip', '{{%project_data}}');
        $this->dropIndex('idx-project_data-hold', '{{%project_data}}');

        $this->dropColumn('{{%project_data}}', 'flip');
        $this->dropColumn('{{%project_data}}', 'hold');

        echo "m181016_152041_add_grad_id_to_project_data are reverted.\n";

        return true;
    }

}
