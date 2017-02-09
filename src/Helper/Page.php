<?php
namespace Helper\Mediawiki;
use \Mediawiki\DataModel\Content;
use \Mediawiki\DataModel\Revision;
use \Mediawiki\DataModel\Title;
use \Mediawiki\DataModel\PageIdentifier;
use \Mediawiki\DataModel\EditInfo;

/**
 * Easy access to a wiki page
 * @author DFelten
 */
class Page {
    private $wiki;
    private $page;
    private $pageTitle;

    /**
     * @param MediawikiApi $wiki
     * @param string $pageTitle title of the page
     */
	public function __construct($wiki, $pageTitle) {
        $this->wiki = $wiki;
        $this->setPage($pageTitle);
	}

    /**
     * Setter for the page
     */
    public function setPage($pageTitle) {
        $this->page = $this->wiki->newPageGetter()->getFromTitle($pageTitle);
        $this->pageTitle = $pageTitle;
    }

    /**
     * Getter for the page
     * @return [type] [description]
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Create a new page or overwrite an existing one
     * @param  string $contentText  content of article
     * @param  string $summary      summary for changes
     * @return boolean              Success?
     */
    public function createPage($contentText, $summary = '', $bot = true) {
        $newContent = new Content($contentText);
        $title = new Title($this->pageTitle);
        $identifier = new PageIdentifier($title);
        $revision = new Revision($newContent, $identifier);
        $editInfo = new EditInfo($summary, false, $bot);
        return $this->wiki->newRevisionSaver()->save($revision, $editInfo);
    }

    /**
     * Edit a page
     * @param  string   $contentText
     * @param  string   $summary
     * @return Boolean  Success?
     */
    public function editPage($contentText, $summary = '') {
        if($this->exist()) {
            $content = new Content($contentText);
            $revision = new Revision($content, $this->page->getPageIdentifier());
            $editInfo = new EditInfo($summary, false, true);
            return $this->wiki->newRevisionSaver()->save($revision, $editInfo);
        } else {
            return false;
        }
    }

    /**
     * Move a Page
     * @param  string $newTitle
     */
    public function movePage($newTitle) {
        $success = $this->wiki->newPageMover()->move(
            $this->page,
            new Title($newTitle)
        );
        $this->setPage($newTitle);
        return $success;
    }

    /**
     * Reason for deletion
     * Attention: Permissions are required
     * @param  string $reason Reason for deletion
     */
    public function deletePage($reason = '') {
        return $this->wiki->newPageDeleter()->delete(
            $this->wiki->newPageGetter()->getFromTitle($this->pageTitle),
            array('reason' => $reason)
        );
    }

    /**
     * Check if article exists
     * @return boolean Article exist
     */
    public function exist() {
        if($this->page->getId() === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Getter for the title
     * @return string Title
     */
    public function getTitle() {
        if (!$this->exist()) return false;

        return $this->page->getTitle();
    }

    /**
     * Getter for the last revision
     * @return Revision
     */
    public function getLastRevision() {
        if (!$this->exist()) return false;

        $revisions = $this->page->getRevisions()->toArray();
        return array_values($revisions)[0];
    }

    /**
     * Check if last revision is from bot
     * TODO: Not working, it's always false
     * @return boolean
     */
    public function isLastRevisionFromBot() {
        if (!$this->exist()) return false;

        $revision = $this->getLastRevision();
        return $revision->getEditInfo();
    }

    /**
     * Get the user of the last revision
     * @return string   user name
     */
    public function getLastRevisionUser() {
        if (!$this->exist()) return false;

        $revision = $this->getLastRevision();
        return $revision->getUser();
    }

    /**
     * Get the timestamp of the last revision
     * @return string   timestamp
     */
    public function getLastRevisionTimestamp() {
        $revision = $this->getLastRevision();
        return $revision->getTimestamp();
    }

    /**
     * Get the summary of the last revision
     * @return string   summary
     */
    public function getLastRevisionSummary() {
        $revision = $this->getLastRevision();
        return $revision->getEditInfo()->getSummary();
    }

    /**
     * Get the content of the last revision
     * @return string   article text
     */
    public function getLastRevisionContent() {
        $revision = $this->getLastRevision();
        return $revision->getContent()->getData();
    }
}
?>
