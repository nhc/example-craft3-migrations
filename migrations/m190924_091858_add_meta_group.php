<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m190924_091858_add_meta_group migration.
 */
class m190924_091858_add_meta_group extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $group = new \craft\models\FieldGroup([
          "name" => "Meta",
        ]);

        // Save the group
        Craft::$app->fields->saveGroup($group);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Find the group
        $group = (new \craft\db\Query())
          ->select("id")
          ->from("fieldgroups")
          ->where(["name" => "Meta"])
          ->one();

        // Delete the group
        return (Craft::$app->fields->deleteGroupById($group["id"]));
    }
}
