<?php

use yii\db\Migration;

/**
 * Class m181010_192924_create_table_exception
 */
class m181010_192924_create_table_exception extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%exceptions}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'site' => $this->string(),
            'msg_true' => $this->string(),
            'msg_fall' => $this->string(),
            'msg_fall2' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        /*exceptions to experts*/
        $this->createIndex(
            'idx-exceptions-project_id',
            'exceptions',
            'project_id'
        );

        $this->addForeignKey(
            'fk-exceptions-project_id',
            'exceptions',
            'project_id',
            'projects',
            'id',
            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-exceptions-project_id', 'exceptions');
        $this->dropIndex('idx-exceptions-project_id', 'exceptions');
        $this->dropTable('{{%exceptions}}');
        return true;
    }
}
