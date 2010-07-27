<?php

/**
 * Migrations between versions 007 and 008.
 */
class Migration008 extends sfMigration
{
  /**
   * Migrate up to version 008.
   */
  public function up()
  {
    $this->loadTransUnits();
  }

  /**
   * Migrate down to version 007.
   */
  public function down()
  {
    $this->deleteTransUnits();
  }
}
