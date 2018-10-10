<?php

use yii\db\Migration;

/**
 * Class m181010_145658_create_table_projects_data
 */
class m181010_145658_create_table_projects_data extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%project_data}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'expert_id' => $this->integer(),
            'Score' => $this->string(),
            'Report_Date' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%project_data}}');
        return true;
    }
}
