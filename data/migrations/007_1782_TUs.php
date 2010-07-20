<?php

/**
 * Migrations between versions 006 and 007.
 */
class Migration007 extends sfMigration
{
  /**
   * Migrate up to version 007.
   */
  public function up()
  {
      TransUnitPeer::createNewUnit('You currently have no photos at all. Please upload some photos first.');
      TransUnitPeer::createNewUnit('You currently have no private photos. You need to make some of your photos private.');
  }

  /**
   * Migrate down to version 006.
   */
  public function down()
  {
      TransUnitPeer::deleteSource('You currently have no photos at all. Please upload some photos first.');
      TransUnitPeer::deleteSource('You currently have no private photos. You need to make some of your photos private.');
  }
}
