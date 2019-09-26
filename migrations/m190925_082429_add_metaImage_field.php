<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m190925_082429_add_metaImage_field migration.
 */
class m190925_082429_add_metaImage_field extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Get the group
        $group = (new \craft\db\Query())
          ->select("id")
          ->from("fieldgroups")
          ->where(["name" => "Meta"])
          ->one();

        // Get the folder to save files to
        $v = Craft::$app->volumes->getVolumeByHandle("contentS3");
        $folder = "volume:" . $v->uid;

        // Initialize the field
        $metaImage = new \craft\fields\Assets([
          "groupId" => $group["id"],
          "name" => "Meta Image",
          "handle" => "metaImage",
          "instructions" => "Choose or upload a meta image",
          "required" => true,
          "restrictFiles" => true,
          "allowedKinds" => ["image"],
          "limit" => 1,
          "viewMode" => "list",
          "selectionLabel" => "Select Meta Image",
          "defaultUploadLocationSource" => $folder,
          "defaultUploadLocationSubpath" => "",
          "singleUploadLocationSource" => $folder,
          "singleUploadLocationSubpath" => "",
          "sources" => [$folder],
          "source" => null,
          "localizeRelations" => "",
          "translationMethod" => "site",
          "translationKeyFormat" => null,
        ]);


        // Save the field
        Craft::$app->getFields()->saveField($metaImage);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190925_082429_add_metaImage_field cannot be reverted.\n";
        return false;
    }
}
