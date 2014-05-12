<?php

function update_elements_function($updates)
{
  $res = "";
  foreach ($updates as $zoneName => $slotName) {
    $res .= update_element_function($zoneName, array('content' => get_slot($slotName)));
  }

  return javascript_tag($res);
}
