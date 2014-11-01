<!DOCTYPE html>
<html lang="{$text['lang']}">
  <head>
    <title>{$text['title']}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{$text['description']}">
    <meta name="keywords" content="{$text['keywords']}">
    <meta name="author" content="{$text['author']}">
    <link type="image/x-icon" href="image/favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cerulean/bootstrap.min.css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    <meta property="og:image" content="{$text['og_image']}"/>
	<meta property="og:title" content="{$text['og_title']}"/>
	<meta property="og:url" content="{$text['og_url']}"/>
	<meta property="og:site_name" content="{$text['og_site_name']}"/>
	<meta property="og:description" content="{$text['og_description']}"/>
	<meta property="og:type" content="website"/>    
    
{block name=additionalHead}{/block} 
  </head>
  <body>
{include "header.tpl"} 
{block name=body}{/block}
{include "footer.tpl"}
{include "google_analytics.tpl"}
  </body>
</html>
