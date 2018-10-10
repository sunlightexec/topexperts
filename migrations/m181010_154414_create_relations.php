<?php

use yii\db\Migration;

/**
 * Class m181010_154414_create_relations
 */
class m181010_154414_create_relations extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        //project to currency
        $this->createIndex(
            'idx-project-Currency_HARD_CAP',
            'projects',
            'Currency_HARD_CAP'
        );
        $this->addForeignKey(
            'fk-project-Currency_HARD_CAP',
            'projects',
            'Currency_HARD_CAP',
            'currencies',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            'idx-project-Currency_ICO_Price',
            'projects',
            'Currency_ICO_Price'
        );

        $this->addForeignKey(
            'fk-project-Currency_ICO_Price',
            'projects',
            'Currency_ICO_Price',
            'currencies',
            'id',
            'SET NULL'
        );

        //project to category
        $this->createIndex(
            'idx-project-Category',
            'projects',
            'Category'
        );

        $this->addForeignKey(
            'fk-project-Category',
            'projects',
            'Category',
            'categories',
            'id',
            'SET NULL'
        );

        //project data to project
        $this->createIndex(
            'idx-project_data-project_id',
            'project_data',
            'project_id'
        );

        $this->addForeignKey(
            'fk-project_data-project_id',
            'project_data',
            'project_id',
            'projects',
            'id',
            'SET NULL'
        );

        /*project data to experts*/
        $this->createIndex(
            'idx-project_data-expert_id',
            'project_data',
            'expert_id'
        );

        $this->addForeignKey(
            'fk-project_data-expert_id',
            'project_data',
            'expert_id',
            'experts',
            'id',
            'SET NULL'
        );


        // add foreign key for table `user`
        /*$this->addForeignKey(
            'fk-post-author_id',
            'post',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );*/
    }

    public function down()
    {
        $this->dropForeignKey('fk-project-Currency_HARD_CAP', '{projects');
        $this->dropForeignKey('fk-project-Currency_ICO_Price', '{projects');
        $this->dropForeignKey('fk-project-Category', '{projects');
        $this->dropForeignKey('fk-project_data-project_id', 'project_data');
        $this->dropForeignKey('fk-project_data-expert_id', 'project_data');

        $this->dropIndex('idx-project-Currency_HARD_CAP','{projects');
        $this->dropIndex('idx-project-Currency_ICO_Price','{projects');
        $this->dropIndex('idx-project-Category','{projects');
        $this->dropIndex('idx-project_data-project_id','project_data');
        $this->dropIndex('idx-project_data-expert_id','project_data');

        echo "m181010_154414_create_relations are reverted.\n";

        return false;
    }

}
