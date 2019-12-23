<?php

use yii\db\Migration;

/**
 * Class m191218_125900_new_column_status_for_comment
 */
class m191218_125900_new_column_status_for_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191218_125900_new_column_status_for_comment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191218_125900_new_column_status_for_comment cannot be reverted.\n";

        return false;
    }
    */
}
