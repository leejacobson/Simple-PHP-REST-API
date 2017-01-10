<?php

namespace TMDB;

use Exception;

/**
 * Class Error
 *
 * @package TMDB_API
 */
class Error extends Exception
{
	/**
     * @return mixed 
     */
	public function getErrorResponse() {
		return json_decode($this->getMessage());
	}
}