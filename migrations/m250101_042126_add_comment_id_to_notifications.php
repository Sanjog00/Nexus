<?php

use yii\db\Migration;

/**
 * Class m250101_042126_add_comment_id_to_notifications
 */
class m250101_042126_add_comment_id_to_notifications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%notifications}}', 'comment_id', $this->integer());
        $this->addColumn('{{%notifications}}', 'comment_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%notifications}}', 'comment_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250101_042126_add_comment_id_to_notifications cannot be reverted.\n";

        return false;
    }
    */
}
