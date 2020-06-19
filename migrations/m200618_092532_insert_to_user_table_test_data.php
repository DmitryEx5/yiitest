<?php

use yii\db\Migration;

/**
 * Class m200618_092532_insert_to_user_table_test_data
 */
class m200618_092532_insert_to_user_table_test_data extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $this->insert('user', [
            'name' => 'admin',
            'password' => '123123',
            'role' => 'admin',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        echo "m200618_092532_insert_to_user_table_test_data cannot be reverted.\n";

        return false;
    }
}
