<?php
require_once(realpath(dirname(__FILE__).'/config.php'));

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();


$fixturesDir = sfConfig::get('sf_data_dir').'/migrations/fixtures/';
$tu_files = sfFinder::type('file')->ignore_version_control()->name('*.tu')->in($fixturesDir);

$sources = array();

foreach($tu_files as $tu_file) $sources = array_merge($sources, explode("\n", file_get_contents($tu_file)));

foreach($sources as $source)
{
    $c = new Criteria();
    $c->add(TransUnitPeer::SOURCE, $source);
    $c->add(TransUnitPeer::CAT_ID, 1);
    $tu = TransUnitPeer::doSelectOne($c);
    
    printf("http://www.polishdate.com/backend.php/transUnits/edit/id/%d\n\n", $tu->getId());
}