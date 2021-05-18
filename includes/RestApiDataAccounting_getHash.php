<?php

namespace MediaWiki\Extension\Example;

use MediaWiki\Rest\SimpleHandler;
use Wikimedia\ParamValidator\ParamValidator;
use MediaWiki\MediaWikiServices;

/**
 * Example class to echo a path parameter
 */
class RestApiDataAccounting_getHash extends SimpleHandler {

	/** @inheritDoc */
	public function run( $rev_id ) {

		 /* *
                 * $dbr = $lb->getConnectionRef( DB_REPLICA );
                 * $res = $dbr->select(
                 * 'category',                              // $table The table to query FROM (or array of tables)
                 * [ 'cat_title', 'cat_pages' ],            // $vars (columns of the table to SELECT)
                 * 'cat_pages > 0',                         // $conds (The WHERE conditions)
                 * __METHOD__,                              // $fname The current __METHOD__ (for performance tracking)
                 * [ 'ORDER BY' => 'cat_title ASC' ]        // $options = []
                 * );
                 * This example corresponds to the query
                 * SELECT cat_title, cat_pages FROM category WHERE cat_pages > 0 ORDER BY cat_title ASC
                **/

		$lb = MediaWikiServices::getInstance()->getDBLoadBalancer();
		$dbr = $lb->getConnectionRef( DB_REPLICA );
		$res = '300';

		# THIS CODE BREAKS AND I DON'T KNOW WHY
		#$res = $dbr->select(
		#'page_verification', 
		#[ 'page_verification_id','signature','public_key' ],
	      	#'page_verification_id = 49',
		#__METHOD__,
		#[ 'ORDER BY' => 'page_verification_id ASC']
		#);

		#This code corresponds to the query
		#SELECT page_verification_id, signature, public_key FROM page_verification WHERE page_verification_id = 55 ORDER BY page_verification_id ASC;

		return "Provide Verification Hash from last revision ID $rev_id and $res.";
	}

	/** @inheritDoc */
	public function needsWriteAccess() {
		return false;
	}

	/** @inheritDoc */
	public function getParamSettings() {
		return [
			'rev_id' => [
				self::PARAM_SOURCE => 'path',
				ParamValidator::PARAM_TYPE => 'integer',
				ParamValidator::PARAM_REQUIRED => true,
                        ],
		];
	}
}
