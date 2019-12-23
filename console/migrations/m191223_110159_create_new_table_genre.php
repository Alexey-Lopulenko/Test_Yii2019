<?php

use yii\db\Migration;

/**
 * Class m191223_110159_create_new_table_genre
 */
class m191223_110159_create_new_table_genre extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('genre', [
            'id' => $this->primaryKey(),
            'genre' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('genre');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191223_110159_create_new_table_genre cannot be reverted.\n";

        return false;
    }
    */
}
