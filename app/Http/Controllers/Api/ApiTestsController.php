<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

class ApiTestsController extends Controller {
	public function get(Request $request) {
		$client = new Client();
		
		$params = $request->all();
		$url = url('api/v2/' . $params['path']);
		unset($params['path']);
		
		$response = $client->get($url, ['json' => $params]);
		return json_decode($response->getBody()->getContents(), true);
	}
	
	public function add(Request $request) {
		$client = new Client();
		
		$params = $request->all();
		$url = url('api/v2/' . $params['path']);
		unset($params['path']);
		
		$response = $client->post($url, ['form_params' => $params]);
		return json_decode($response->getBody()->getContents(), true);
	}
	
	public function save(Request $request) {
		$client = new Client();
		
		$params = $request->all();
		$url = url('api/v2/' . $params['path']);
		unset($params['path']);
		
		try {
			$response = $client->put($url, ['form_params' => $params]);
			return json_decode($response->getBody()->getContents(), true);
		} catch (ServerException $e) {
			echo $e->getResponse()->getBody()->getContents();
		}
	}
	
	public function delete(Request $request) {
		$client = new Client();
		
		$params = $request->all();
		$url = url('api/v2/' . $params['path']);
		unset($params['path']);
		
		$response = $client->delete($url, ['json' => $params]);
		return json_decode($response->getBody()->getContents(), true);
	}
}