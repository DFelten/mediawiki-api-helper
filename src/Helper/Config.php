<?php
namespace Helper\Mediawiki;
use \Mediawiki\Api\MediawikiApi;
use \Mediawiki\Api\MediawikiFactory;
use \Mediawiki\Api\ApiUser;

/**
 * Config file for easy access to a MediaWiki and
 * a second MediaWiki for development
 * @author DFelten
 */
class Config {
    /**
     * Getter for the API
     * @param  boolean $dev Dev wiki or productive?
     * @return MediawikiApi
     */
    private function getAPI($dev)
    {
        $ini = parse_ini_file("../config.ini");

        if($ini["dev"]) {
            $url = $ini["dev_url"];
            $user = $ini["dev_user"];
            $pw = $ini["dev_pw"];
        } else {
            $url = $ini["url"];
            $user = $ini["user"];
            $pw = $ini["pw"];
        }
        $api = MediawikiApi::newFromApiEndpoint($url);
        $api->login(new ApiUser($user, $pw));

        return $api;
    }

    /**
     * Get the MediawikiApi object
     * @param  boolean $dev development wiki or productive?
     * @return MediawikiApi
     */
    public function getWiki($dev=true){
        return new MediawikiFactory($this->getAPI($dev));
    }
}
?>
