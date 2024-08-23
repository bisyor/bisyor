<?php

use yii\db\Migration;
use backend\models\references\Regions;
use Cocur\Slugify\Slugify;

/**
 * Handles adding columns to table `{{%regions}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%countries}}`
 */
class m200921_122443_add_country_id_column_to_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%regions}}', 'country_id', $this->integer());

        // creates index for column `country_id`
        $this->createIndex(
            '{{%idx-regions-country_id}}',
            '{{%regions}}',
            'country_id'
        );

        // add foreign key for table `{{%countries}}`
        $this->addForeignKey(
            '{{%fk-regions-country_id}}',
            '{{%regions}}',
            'country_id',
            '{{%countries}}',
            'id',
            'CASCADE'
        );

        $regions = Regions::find()->all(); 
        foreach($regions as $value)
            {
                $value->country_id = 1;
                $value->save();        
            }
            
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%countries}}`
        $this->dropForeignKey(
            '{{%fk-regions-country_id}}',
            '{{%regions}}'
        );

        // drops index for column `country_id`
        $this->dropIndex(
            '{{%idx-regions-country_id}}',
            '{{%regions}}'
        );

        $this->dropColumn('{{%regions}}', 'country_id');
    }
}
