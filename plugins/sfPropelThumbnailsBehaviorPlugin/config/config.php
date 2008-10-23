<?php
sfPropelBehavior::registerMethods('thumbnails', array(
  array('sfPropelThumbnailsBehavior', 'getImagesDir'),
  array('sfPropelThumbnailsBehavior', 'getImagesPath'),
  array('sfPropelThumbnailsBehavior', 'getImagePath'),
  array('sfPropelThumbnailsBehavior', 'getImageFilename'),
  array('sfPropelThumbnailsBehavior', 'getImageUrlPath'),
  array('sfPropelThumbnailsBehavior', 'getThumbSizes'),
  array('sfPropelThumbnailsBehavior', 'createThumbnails'),
  array('sfPropelThumbnailsBehavior', 'deleteThumbnails'),
  array('sfPropelThumbnailsBehavior', 'deleteImage'),
  array('sfPropelThumbnailsBehavior', 'updateImageFromRequest'),
  array('sfPropelThumbnailsBehavior', 'updateImageFromFile'),
));

sfPropelBehavior::registerHooks('thumbnails', array(
  ':delete:pre' => array('sfPropelThumbnailsBehavior', 'preDelete'),
));
