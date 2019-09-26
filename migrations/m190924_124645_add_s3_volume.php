<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\services\Volumes;

/**
 * m190924_124645_add_s3_volume migration.
 */
class m190924_124645_add_s3_volume extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $settings = '{"subfolder":"","keyId":"","secret":"","bucketSelectionMode":"manual","bucket":"$S3_BUCKET","region":"$S3_REGION","expires":"30 minutes","makeUploadsPublic":"1","storageClass":"","cfDistributionId":"$S3_CLOUDFRONT_DISTRIBUTION_ID","cfPrefix":"","autoFocalPoint":""}';

        $volumeConfig = [
          'name' => 'Content - S3',
          'handle' => 'contentS3',
          'type' => \craft\awss3\Volume::class,
          'hasUrls' => true,
          'url' => '$S3_URL',
          'settings' => json_decode($settings, true)
        ];

        $volumeInterface = Craft::$app->getVolumes()->createVolume($volumeConfig);

        return Craft::$app->getVolumes()->saveVolume($volumeInterface);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $volume = Craft::$app->getVolumes()->getVolumeByHandle('contentS3');
        Craft::$app->getVolumes()->deleteVolume($volume);
    }
}
