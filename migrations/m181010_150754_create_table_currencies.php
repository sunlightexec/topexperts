<?php

use yii\db\Migration;

/**
 * Class m181010_150754_create_table_currencies
 */
class m181010_150754_create_table_currencies extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%currencies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'value' => $this->double()->defaultValue(1),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%currencies}}');
        return true;
    }
}
