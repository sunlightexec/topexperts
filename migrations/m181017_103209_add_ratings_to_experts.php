<?php

use yii\db\Migration;

/**
 * Class m181017_103209_add_ratings_to_experts
 */
class m181017_103209_add_ratings_to_experts extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%experts}}', 'flip', $this->double()->defaultValue(0)->after('comments'));
        $this->addColumn('{{%experts}}', 'hold', $this->double()->defaultValue(0)->after('flip'));
    }

    public function down()
    {
        $this->dropColumn('{{%experts}}', 'flip');
        $this->dropColumn('{{%experts}}', 'hold');

        echo "m181017_103209_add_ratings_to_experts are reverted.\n";

        return true;
    }

}
