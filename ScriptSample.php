<?php
require_once('src/Init.php');
require_once('mw/MWCreatures.php');
use \Helper\Page;
use \Helper\Functions;

/**
 * Example script to work with the helpers
 * @author DFelten
 */
class ScriptSample {
    /**
     * Constructor with examples of the page helper class
     * For more see Helper/Page.php
     *
     * @param MediawikiApi $wiki
     */
    public function __construct($wiki) {
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
    }
}

$scriptSample = new ScriptSample($wiki);
