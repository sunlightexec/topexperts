<?php

use yii\db\Migration;

/**
 * Class m181025_132827_add_date_added_to_projects
 */
class m181025_132827_add_date_added_to_projects extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%projects}}', 'start_coin', $this->integer()->comment('Date start coin'));
        $this->createIndex('idx-projects-start_coin', '{{%projects}}', 'start_coin');
        $this->createIndex('idx-projects-created_at', '{{%projects}}', 'created_at');
    }

    public function down()
    {
        $this->dropIndex('{{%projects}}', 'start_coin');
        $this->dropIndex('idx-projects-start_coin', '{{%projects}}');
        $this->dropColumn('idx-projects-created_at', '{{%projects}}');

        echo "m181025_132827_add_date_added_to_projects are reverted.\n";

        return true;
    }

}
