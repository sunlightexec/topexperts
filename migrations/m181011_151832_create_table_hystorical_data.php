<?php

use yii\db\Migration;

/**
 * Class m181011_151832_create_table_hystorical_data
 */
class m181011_151832_create_table_hystorical_data extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%hystorical_data}}', [
            'id' => $this->primaryKey(),
            'currency_id' => $this->integer(),
            'circulating_supply' => $this->double(10),
            'total_supply' => $this->double(10),
            'max_supply' => $this->double(10),
            'date_added' => $this->integer(),
            'price' => $this->double(10),
            'volume_24h' => $this->double(10),
            'market_cap' => $this->double(10),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        /*exceptions to experts*/
        $this->createIndex(
            'idx-hystorical_data-currency_id',
            'hystorical_data',
            'currency_id'
        );

        $this->addForeignKey(
            'fk-hystorical_data-currency_id',
            'hystorical_data',
            'currency_id',
            'currencies',
            'id',
            'SET NULL'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-hystorical_data-currency_id', 'hystorical_data');
        $this->dropIndex('idx-hystorical_data-currency_id', 'hystorical_data');
        $this->dropTable('{{%hystorical_data}}');
        return true;
    }
}
