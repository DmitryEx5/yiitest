<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%recipe}}`.
 */
class m200617_224113_create_recipe_table extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%recipe}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(155)->notNull()->unique(),
            'isHidden' => $this->tinyInteger()->defaultValue(0)->notNull(),
            'created' => $this->dateTime(),
            'updated' => $this->dateTime(),
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('{{%recipe}}');
    }
}
