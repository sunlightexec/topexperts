<?php

use yii\db\Migration;

/**
 * Class m181012_114256_modify_historical_data
 */
class m181012_114256_modify_historical_data extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        \app\models\helpers\HystoricalData::deleteAll();

        $this->addColumn('{{%hystorical_data}}', 'project_id', $this->integer()->notNull()->after('id'));

        $this->createIndex(
            'idx-hystorical_data-project_id',
            '{{%hystorical_data}}',
            'project_id'
        );

        $this->addForeignKey(
            'fk-hystorical_data-project_id',
            '{{%hystorical_data}}',
            'project_id',
            '{{%projects}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropIndex('idx-hystorical_data-project_id',
            '{{%hystorical_data}}');
        $this->dropForeignKey('fk-hystorical_data-project_id',
            '{{%hystorical_data}}');
        $this->dropColumn('{{%hystorical_data}}', 'project_id');

        echo "m181012_114256_modify_historical_data are reverted.\n";

        return true;
    }

}
