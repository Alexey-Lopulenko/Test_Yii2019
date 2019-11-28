<?php

use yii\db\Migration;

/**
 * Class m191128_094204_nev_column_in_order
 */
class m191128_094204_nev_column_in_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'film_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'film_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191128_094204_nev_column_in_order cannot be reverted.\n";

        return false;
    }
    */
}
