# mediawiki-api-helper
Helper for the addwiki MediaWiki API with an example script and easy configuration.

## Installation
1. Install [mediawiki-api](https://github.com/addwiki/mediawiki-api) and all dependencies
2. Copy or rename the configSample.ini to config.ini
3. Fill in the ini with the data of your MediaWiki
4. Look at the ScriptSample.php

## Example Usage
Extract of the ScriptSample.php
```php
require_once('src/Init.php');
use \Helper\Page;
use \Helper\Functions;

//(...)

//Create the page object
$page = new Page("Article name", "Article content");

//Create or edit the article
if($page->createPage($articleText)) {
    echo "Success";
} else {
    echo "Error";
}

//Edit the article (only if article already exist)
if($page->editPage("Testderzweite2")) {
    echo "Success";
} else {
    echo "Error";
}

//Move the article
if($page->movePage("Testderzweite2")) {
    echo "Success";
} else {
    echo "Error";
}

//Get author of the last revision
$page->getLastRevisionUser("Testderzweite2");

//Check if article exist
if($page->exist()) {
    echo "Article exists";
} else {
    echo "Article doesn't exist";
}

//Example of other functions (see Functions.php)
$functions = new Functions();
$functions->getPagesWithinCategory();
```
