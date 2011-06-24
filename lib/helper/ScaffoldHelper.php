<?php

function get_scaffold_stylesheets()
{
  $html = '';
  $response = sfContext::getInstance()->getResponse();
  foreach ($response->getStylesheets() as $file => $options)
  {
    $html .= stylesheet_tag('/scss/' . $file);
  }

  return $html;
}

function include_scaffold_stylesheets()
{
  echo get_scaffold_stylesheets();
}