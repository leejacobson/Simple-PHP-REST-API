<?php

namespace TMDB;

/**
 * Class Api
 *
 * @property array $config
 *
 * @package TMDB_API
 */
class Api
{
	private $config;

	/**
     * @param array $config TMDB API config
     */
	public function __construct($config) {
		$this->config = $config;
	}

	/**
     * @param string $resouce Requested API resource
	 * @return string Full resouce URL
     */
	private function getResourceUrl($resouce) {
		return $this->config['apiUrl'] . '/' . $this->config['apiVersion'] . $resouce . '?api_key=' . $this->config['apiKey'];
	}

	/**
     * @param string $resource Requested API resource
	 * @param array $params Query parameters
	 * @return array Response from API
     */
	public function get($resouce, $params = array()) {
		$ch = curl_init($this->getResourceUrl($resouce) . '&' . http_build_query($params));
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");  
		$return = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($httpcode != 200) {
			throw new \TMDB\Error($return);
		}

		return json_decode($return);
	}
}
