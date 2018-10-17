<?php

use yii\db\Migration;

/**
 * Class m181017_113000_add_ratings_to_projects
 */
class m181017_113000_add_ratings_to_projects extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%projects}}', 'flip_all', $this->double()->defaultValue(0)->after('Scam'));
        $this->addColumn('{{%projects}}', 'flip_12', $this->double()->defaultValue(0)->after('flip_all'));
        $this->addColumn('{{%projects}}', 'flip_3', $this->double()->defaultValue(0)->after('flip_12'));
        $this->addColumn('{{%projects}}', 'hold_all', $this->double()->defaultValue(0)->after('flip_3'));
        $this->addColumn('{{%projects}}', 'hold_12', $this->double()->defaultValue(0)->after('hold_all'));
        $this->addColumn('{{%projects}}', 'hold_3', $this->double()->defaultValue(0)->after('hold_12'));
    }

    public function down()
    {
        $this->dropColumn('{{%projects}}', 'flip_all');
        $this->dropColumn('{{%projects}}', 'flip_12');
        $this->dropColumn('{{%projects}}', 'flip_3');
        $this->dropColumn('{{%projects}}', 'hold_all');
        $this->dropColumn('{{%projects}}', 'hold_12');
        $this->dropColumn('{{%projects}}', 'hold_3');

        echo "m181017_113000_add_ratings_to_projects are reverted.\n";

        return true;
    }

}
