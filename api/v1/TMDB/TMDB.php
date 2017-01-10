<?php

namespace TMDB;

require_once('Api.php');
require_once('Error.php');

/**
 * Class TMDB
 * https://www.themoviedb.org/documentation/api
 *
 * @property array $config
 *
 * @package TMDB_API
 */
class TMDB extends Api{
	/**
     * @param array $config TMDB API config
     */
	public function __construct($config) {
		parent::__construct($config);
	}

	/**
     * @param string $film Film search query
	 * @return array Search results
     */
	public function searchFilm($film) {
		return $this->get('/search/movie', array('query' => $film));
	}
}