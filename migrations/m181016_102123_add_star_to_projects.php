<?php

use yii\db\Migration;

/**
 * Class m181016_102123_add_star_to_projects
 */
class m181016_102123_add_star_to_projects extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%projects}}', 'ICO_Star',
            $this->integer()
                ->defaultValue(0)
                ->after('Currency_ICO_Price')
        );

        $this->addColumn('{{%projects}}', 'flip', $this->double()->defaultValue(0)->after('ICO_Star'));
        $this->addColumn('{{%projects}}', 'hold', $this->double()->defaultValue(0)->after('flip'));

        $this->createIndex('idx-projects-flip', '{{%projects}}', 'flip');
        $this->createIndex('idx-projects-hold', '{{%projects}}', 'hold');

        $this->addColumn('{{%project_data}}', 'flip', $this->double()->defaultValue(0)->after('Report_Date'));
        $this->addColumn('{{%project_data}}', 'hold', $this->double()->defaultValue(0)->after('flip'));

        $this->createIndex('idx-project_data-flip', '{{%project_data}}', 'flip');
        $this->createIndex('idx-project_data-hold', '{{%project_data}}', 'hold');
    }

    public function down()
    {
        $this->dropIndex('idx-projects-flip');
        $this->dropIndex('idx-projects-hold');
        $this->dropIndex('idx-project_data-flip');
        $this->dropIndex('idx-project_data-hold');
        $this->dropColumn('{{%project_data}}', 'flip');
        $this->dropColumn('{{%project_data}}', 'hold');
        $this->dropColumn('{{%projects}}', 'flip');
        $this->dropColumn('{{%projects}}', 'hold');
        $this->dropColumn('{{%projects}}', 'ICO_Star');
        echo "m181016_102123_add_star_to_projects are reverted.\n";

        return true;
    }

}
