<?php

use yii\db\Migration;

/**
 * Class m181016_121657_table_graduation_ratings
 */
class m181016_121657_table_graduation_ratings extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%graduation_ratings}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type' => $this->smallInteger()->defaultValue(1),
            'min_star' => $this->smallInteger()->defaultValue(8),
            'divider' => $this->smallInteger()->defaultValue(1),
            'max_value' => $this->smallInteger()->defaultValue(1),
            'allowed' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addColumn('{{%project_data}}', 'graduation_id', $this->integer()->after('Score'));

        $this->createIndex(
            'idx-project_data-graduation_id',
            '{{%project_data}}',
            'graduation_id'
        );

        $this->addForeignKey(
            'fk-project_data-graduation_id',
            '{{%project_data}}',
            'graduation_id',
            '{{%graduation_ratings}}',
            'id',
            'SET NULL'
        );

    }

    public function down()
    {
        $this->dropForeignKey('fk-project_data-graduation_id', '{{%project_data}}');
        $this->dropIndex('idx-project_data-graduation_id', '{{%project_data}}');
        $this->dropColumn('{{%project_data}}', 'graduation_id');

        $this->dropTable('{{%graduation_ratings}}');
        echo "m181016_121657_table_graduation_ratings are reverted.\n";

        return true;
    }
}
