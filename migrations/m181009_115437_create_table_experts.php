<?php

use yii\db\Migration;

/**
 * Class m181009_115437_create_table_experts
 */
class m181009_115437_create_table_experts extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%experts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'website' => $this->string(),
            'old_description' => $this->text(),
            'description' => $this->text(),
            'spreadsheet' => $this->string(),
            'count_ratings' => $this->string(50),
            'grading_ratings' => $this->string(),
            'paid_ratings' => $this->string(),
            'address' => $this->text(),
            'email' => $this->string(),
            'subscribe' => $this->string(),
            'comments' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%experts}}');
        return true;
    }
}
