<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%items_countres}}`.
 */
class m201019_111952_drop_id_column_from_items_countres_table extends Migration
{
    public function up()
    {
        $this->dropColumn('items_counters', 'id');
    }

    public function down()
    {
        $this->addColumn('items_counters', 'id', $this->integer());
    }
}
