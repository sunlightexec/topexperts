<?php

use yii\db\Migration;

/**
 * Class m181012_130841_fix_prjs
 */
class m181012_130841_fix_prjs extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->dropTable('{{%project_synonims}}');
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%project_synonims}}', [
            'id' => $this->primaryKey(),
            'project_name' => $this->string()->notNull(),
            'project_synonim' => $this->text()/*->defaultValue('{}')*/,

            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m181012_130841_fix_prjs cannot be reverted.\n";

        return false;
    }

}
