<?php
namespace Helper;

/**
 * Various helper functions for the MediaWiki access
 * @author DFelten
 */
class Functions {
    private $wiki;
    private $pageListGetter;

    /**
	 * @param MediawikiApi $wiki
	 */
	public function __construct($wiki) {
        $this->wiki = $wiki;
        $this->pageListGetter = $this->wiki->newPageListGetter();
	}

    public function getPagesWithinCategory($categoryName){
        return $this->pageListGetter->getPageListFromCategoryName("Category:$categoryName");
    }

    public function getPagesWithTemplate($templateName){
        return $this->pageListGetter->getPageListFromPageTransclusions("Template:$templateName");
    }

    public function getPagesWithLinksToPage($pageName){
        return $this->pageListGetter->getFromWhatLinksHere($pageName);
    }

    public function imageUpload($pageName){
        return $this->pageListGetter->getFromWhatLinksHere($pageName);
    }

    /**
     * Get random pages.
     *
     * @param  string $limit            How many pages to get. No more than 10 (20 for bots) allowed.
     * @param  string $namespaces       Pipe-separate list of namespace IDs.
     * @param  string $redirectFilter   How to filter for redirects. Possible values: all, redirects, nonredirects. Default: nonredirects.
     * @return Pages                    Pages
     */
    public function getRandomPages($limit='7', $namespaces='0', $redirectFilter='all'){
        return $this->pageListGetter->getRandom( [
            'rnlimit' => 7,
            'rnnamespace' => '3|5|6',
            'rnfilterredir' => 'all',
        ]);
    }
}
