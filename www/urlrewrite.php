<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^/product/([0-9a-zA-Z_-]+)?(.*)#',
    'RULE' => 'ELEMENT_CODE=$1',
    'ID' => '',
    'PATH' => '/product/detail.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/tree-api/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/local/ajax/menu-process.php',
    'SORT' => 100,
  ),
);
