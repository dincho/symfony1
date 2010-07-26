<?php use_helper('Window'); ?>

<h1>dwPrototypeWindowPlugin</h1>

<h2>You can open the debug window if you want to see some debug outputs.</h2>
<?php

// Example 0 : Debug window
echo link_to_prototype_debug('(click here)');

?>

<h2>&raquo; Example 1 : Open a simple window </h2>
<?php


// Example 1 : Open a simple window ============================================
echo link_to_prototype_window(

    // text for link
    '(click here)',

    // window id (no space or special chars)
    'win_example1',

    // window options
    array(
    'className' => 'dialog',
    'draggable' => 'true',
    'center' => 'true',
    'width' => '350',
    'height' => '400',
    'zIndex' => '100',
    'resizable' => 'true',
    'title' => 'Sample window',
    'showEffect' => 'Effect.BlindDown',
    'hideEffect' => 'Effect.SwitchOff',
    'wiredDrag' => 'true',
    'status'    => 'Status bar info',

    // for Symfony
    'url' => 'dwPrototypeWindowPlugin/Example1Content',
    ),

    // html otpions
    array(
    'absolute' => true,  // Don't forget it you take content from sf
    )
);
?>

<h2>&raquo; Example 2 : Open a window with an URL inside</h2>
<?php

// Example 2 : Open a window with an URL inside ================================
echo link_to_prototype_window(

    // text for link
    '(click here)',

    // window id (no space or special chars)
    'win_example2',

    // window options
    array(
    'className' => 'spread',
    'title' => 'Symfony',
    'top' => 70,
    'left' => 100,
    'width' => 500,
    'height' => 300,
    'url' => 'http://www.symfony-project.com',
    'showEffectOptions' => '{duration:1.5}',
    ),

    // html otpions
    array(
    )
);

?>

<h2>&raquo; Example 3 : Open a window with an existing content inside</h2>
<?php

// Example 3 : Open a window with an existing content inside ===================
echo link_to_prototype_window_from_content(

    // text for link
    '(click here)',

    // window id (no space or special chars)
    'win_example3',

    // content to use
    'test_content',

    // window options
    array(
    'maximizable' => 'false',
    'resizable' => 'true',
    'showEffect' => 'Element.show',
    'hideEffect' => 'Element.hide',
    'minWidth' => 10,
    ),

    // html otpions
    array(
    )
);
?>

<div id="test_content" style="float:right;width:100px; height:150px;background:#DFA; color:#000; font-size:12px;">
Lorem ipsum dolor sit amet, consectetur adipiscing elit
</div>

<h2>&raquo; Example 4 : Open an alert dialog</h2>
<?php
// Example 4 : Open an alert dialog ============================================
echo link_to_prototype_dialog(

    // text for link
    '(click here)',

    // content
    'Test of alert panel, check out debug window after closing it',

    // dialog type
    'alert',

    // window options
    array(
    'className' => 'alert',
    'width' => 300,
    'height' => 100,
    'okLabel' => 'close',
    //'debug' => 'validate alert panel',
    ),

    // html otpions
    array(
    )
);
?>

<h2>&raquo; Example 5 : Open a confirm dialog</h2>
<?php
// Example 5 : Open an alert dialog ============================================
echo link_to_prototype_dialog(

    // text for link
    '(click here)',

    // content
    'Test of confirm panel, check out debug window after closing it.',

    // dialog type
    'confirm',

    // window options
    array(
    'width' => 300,
    'okLabel' => 'close',
    'buttonClass' => 'myButtonClass',
    'id' => 'myDialogId',
    ),

    // html otpions
    array(
    )
);
?>

<style>
#myDialogId .myButtonClass {
  padding:3px;
  font-size:20px;
  width:100px;
}
#myDialogId .ok_button {
  color:#2F2;
}
#myDialogId .cancel_button {
  color:#F88;
}
</style>

<h2>Old tests</h2>

<?php echo link_to_prototype_window('Google', 'google', array('title' => 'Google', 'url' => 'http://google.com', 'width' => '520', 'height' => '350', 'center' => 'true', 'className' => 'alphacube'), array('absolute' => true)); ?>

<?php echo link_to_prototype_dialog('hello', 'hello world', 'alert', array('className' => 'alphacube')); ?>