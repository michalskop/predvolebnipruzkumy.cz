<!DOCTYPE html>
<html lang="{$text['lang']}">
  <head>
    <title>{$text['title']}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cerulean/bootstrap.min.css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
{block name=additionalHead}{/block} 
  </head>
  <body>
{include "header.tpl"} 
{block name=body}{/block}
{include "footer.tpl"}
  </body>
</html>
