<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m190925_102805_add_globalset_meta migration.
 */
class m190925_102805_add_globalset_meta extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $gs = new \craft\elements\GlobalSet();
        $gs->name = "Meta";
        $gs->handle = "meta";

        $topTab = new \craft\models\FieldLayoutTab(["name" => "Meta Field Layout"]);
        $metaImageField = Craft::$app->getFields()->getFieldByHandle('metaImage');
        $topTab->setFields([$metaImageField]);

        $fieldLayout = new \craft\models\FieldLayout();
        $fieldLayout->setFields([$metaImageField]);
        $fieldLayout->type = GlobalSet::class;
        $fieldLayout->setTabs([$topTab]);

        Craft::$app->getFields()->saveLayout($fieldLayout);

        $gs->setFieldLayout($fieldLayout);

        Craft::$app->getGlobals()->saveSet($gs);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $gs = \craft\elements\GlobalSet::find()
                ->handle('meta')
                ->one();

        Craft::$app->getGlobals()->deleteGlobalSetById($gs->id);
    }
}
