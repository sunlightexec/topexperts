<?php

use yii\db\Migration;

/**
 * Class m181022_103417_add_star_hold_to_projects
 */
class m181022_103417_add_star_hold_to_projects extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%projects}}', 'ICO_Star_Hold', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%projects}}', 'ICO_Star_Hold');
        echo "m181022_103417_add_star_hold_to_projects are reverted.\n";

        return true;
    }

}
