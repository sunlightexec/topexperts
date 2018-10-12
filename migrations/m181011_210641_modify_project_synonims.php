<?php

use yii\db\Migration;

/**
 * Class m181011_210641_modify_project_synonims
 */
class m181011_210641_modify_project_synonims extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        \app\models\search\ProjectSynonims::deleteAll();

        $this->addColumn('{{%project_synonims}}', 'expert_id', $this->integer()->notNull());
//        $this->dropColumn('{{%project_synonims}}', 'project_name');

        //project data to project
        $this->createIndex(
            'idx-project_synonims-expert_id',
            'project_synonims',
            'expert_id'
        );

        $this->addForeignKey(
            'fk-project_synonims-expert_id',
            'project_synonims',
            'expert_id',
            'experts',
            'id'
//            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-project_synonims-expert_id','{{%project_synonims}}');
        $this->dropIndex('idx-project_synonims-expert_id','{{%project_synonims}}');
        $this->dropColumn('{{%project_synonims}}', 'expert_id');
        $this->addColumn('{{%project_synonims}}', 'project_name', $this->string()->notNull());
        echo "m181011_210641_modify_project_synonims are reverted.\n";

        return true;
    }

}
