<?php
if (!function_exists('_dd')) {
  function _dd(...$args)
  {
     if (!headers_sent()) {
         header('HTTP/1.1 500 Internal Server Error');
     }
     call_user_func_array('dd', $args);
  }
}