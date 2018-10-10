<?php

use yii\db\Migration;

/**
 * Class m181010_145452_create_table_projects
 */
class m181010_145452_create_table_projects extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%projects}}', [
            'id' => $this->primaryKey(),
            'ICO_NAME' => $this->string()->notNull()->unique(),
            'ICO_Website' => $this->string(),
            'ICO_Description' => $this->text(),
            'URL_Coinmarketcap' => $this->string(),
            'URL_ICODrops' => $this->string(),
            'Category' => $this->integer(),
            'HARD_CAP' => $this->double(),
            'Currency_HARD_CAP' => $this->integer(),
            'ICO_Price' => $this->double(),
            'Currency_ICO_Price' => $this->integer(),
            'START_ICO' => $this->integer(),
            'END_ICO' => $this->integer(),
            'Scam' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%projects}}');
        return true;
    }
}
