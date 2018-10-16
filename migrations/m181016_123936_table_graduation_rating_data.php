<?php

use yii\db\Migration;

/**
 * Class m181016_123936_table_graduation_rating_data
 */
class m181016_123936_table_graduation_rating_data extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%graduation_rating_data}}', [
            'id' => $this->primaryKey(),
            'graduation_id' => $this->integer()->null(),
            'score' => $this->string(),
            'value' => $this->double(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            'idx-graduation_rating_data-graduation_id',
            '{{%graduation_rating_data}}',
            'graduation_id'
        );

        $this->addForeignKey(
            'fk-graduation_rating_data-graduation_id',
            '{{%graduation_rating_data}}',
            'graduation_id',
            '{{%graduation_ratings}}',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-graduation_rating_data-graduation_id', '{{%graduation_rating_data}}');
        $this->dropIndex('idx-graduation_rating_data-graduation_id', '{{%graduation_rating_data}}');

        $this->dropTable('{{%graduation_rating_data}}');

        echo "m181016_123936_table_graduation_rating_data are reverted.\n";

        return true;
    }

}
