<?php

require_once('TMDB/TMDB.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method != "GET") {
	http_response_code(405);
	$error = array ('err' => 1, 'msg' => 'Invalid request method');
	die(json_encode($error));
}

$request = isset($_GET['request']) ? $_GET['request'] : '';

switch ($request) {
	case 'search':
		$query = isset($_GET['query']) ? $_GET['query'] : '';

		if (empty($query)) {
			http_response_code(400);
			$error = array ('err' => 1, 'msg' => 'Query parameter empty');
			die(json_encode($error));
		}

		// API creds can be found here,
		// https://www.themoviedb.org/documentation/api
		$tmdb = new \TMDB\TMDB(array('apiUrl' => '[API URL]',
					'apiKey' => '[API KEY]',
					'apiVersion' => 3));

		try {
			$result = $tmdb->searchFilm($query);
			$apiResult = array(
				'err' => 0,
				'films' => array(),
			);
			foreach ($result->results as $film) {
				$apiResult['films'][] = $film->title . ' (' . date('Y', strtotime($film->release_date)) . ')';
			}
			
			echo json_encode($apiResult, JSON_UNESCAPED_UNICODE);
		} catch (\TMDB\Error $e) {
			http_response_code(500);
			$error = array ('err' => 1, 'msg' => 'API Error', 'apiResponse' => $e->getErrorResponse());
			echo json_encode($error, JSON_UNESCAPED_UNICODE);
		}
		break;
	default:
		http_response_code(404);
		$error = array ('err' => 1, 'msg' => 'Resource not found');
		echo json_encode($error);
}