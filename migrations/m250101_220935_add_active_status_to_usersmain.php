<?php

use yii\db\Migration;

/**
 * Class m250101_220935_add_active_status_to_usersmain
 */
class m250101_220935_add_active_status_to_usersmain extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%usersmain}}', 'active_status', $this->boolean()->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%usersmain}}', 'active_status');
    }


    // Use up()/down() to run migration code without a transaction.
    public function up() {}

    public function down()
    {
        echo "m250101_220935_add_active_status_to_usersmain cannot be reverted.\n";

        return false;
    }
}
