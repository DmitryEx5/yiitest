<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%recipe_ingredient}}`.
 */
class m200617_234530_create_recipe_component_table extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%recipe_component}}', [
            'recipe_id' => $this->integer(),
            'component_id' => $this->integer(),
            'created' => $this->dateTime(),
            'updated' => $this->dateTime(),
            'PRIMARY KEY(recipe_id, component_id)',
        ]);

        $this->createIndex(
            'idx-recipe_component-recipe_id',
            'recipe_component',
            'recipe_id'
        );

        $this->addForeignKey(
            'fk-recipe_component-recipe_id',
            'recipe_component',
            'recipe_id',
            'recipe',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-recipe_component-component_id',
            'recipe_component',
            'component_id'
        );

        $this->addForeignKey(
            'fk-recipe_component-component_id',
            'recipe_component',
            'component_id',
            'component',
            'id',
            'CASCADE'
        );

    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-recipe_component-recipe_id',
            'recipe_component'
        );

        $this->dropIndex(
            'idx-recipe_component-recipe_id',
            'recipe_component'
        );

        $this->dropForeignKey(
            'fk-recipe_component-component_id',
            'recipe_component'
        );

        $this->dropIndex(
            'idx-recipe_component-component_id',
            'recipe_component'
        );

        $this->dropTable('{{%recipe_component}}');
    }
}
