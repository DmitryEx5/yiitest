<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%component}}`.
 */
class m200617_224013_create_component_table extends Migration
{

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%component}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'isHidden' => $this->tinyInteger()->defaultValue(0)->notNull(),
            'created' => $this->dateTime()->notNull(),
            'updated' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('{{%component}}');
    }
}
