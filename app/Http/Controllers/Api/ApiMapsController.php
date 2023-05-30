<?php namespace App\Http\Controllers\Api;

use App\Api;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Http\Request;

class ApiMapsController extends Controller
{
    private $client = null;

    public function __construct()
    {
        parent::__construct();
        $this->client = new \GuzzleHttp\Client();
    }

    public function getPolygons(Request $request)
    {
        $cities = $request->input('city');
        $clear = $request->input('clear');

        if (is_null($cities)) {
            return '[postal_code] is empty!';
        }

        $results = [];

        if (!is_array($cities)) {
            $cities = [$cities];
        }

        if (count($cities) == 1 && strpos($cities[0], ',')) {
            $cities = explode(',', $cities[0]);
        }

        foreach ($cities as $city) {
            if ($clear) {
                Cache::forget('polygons_' . $city);
            }

            $cached = true;

            //$result = Cache::get('polygons_' . $city);

            $result = Cache::rememberForever('polygons_' . $city, function () use ($city, &$cached) {
                $result = [];

                $cached = false;

                // @see https://wiki.openstreetmap.org/wiki/Nominatim
                $params = [
                    'countrycodes' => 'BE',
                    'dedupes' => 1,
                    'email' => 'hardik.mehta@boxify.be',//'private@cherrypulp.com',
                    'extratags' => 0,
                    'format' => 'json',
                    'q' => $city,
                ];
                $response = $this->client->request('GET', 'https://nominatim.openstreetmap.org/search', [
                    'query' => $params,
                ]);

                if ($response->getStatusCode() == 200) {
                    $response = collect(json_decode($response->getBody()->getContents(), true));
                    $id = $response->filter(function ($res) {
                        return array_key_exists('osm_id', $res) && $res['osm_type'] == 'relation';
                    })->map(function ($res) {
                        return $res['osm_id'];
                    })->toArray();
                    if (is_array($id) && !empty($id)) {
                        $id = array_first($id);
                    } else {
                        $id = null;
                    }

                    if ($id) {
                        $params = [
                            'id' => $id,
                        ];
                        $response = $this->client->request('GET', 'http://polygons.openstreetmap.fr/get_geojson.py', [
                            'query' => $params,
                        ]);

                        if ($response->getStatusCode() == 200 && $response->getBody()->getContents()) {
                            $response = json_decode($response->getBody()->getContents(), true);
                            $coordinates = array_get($response, 'geometries.0.coordinates');
                            if(!is_null($coordinates)) {
                                foreach ($coordinates as $coordinate) {
                                    $result['coordinates'][] = $coordinate[0];
                                }
                            }
                        }
                    }
                }

                return $result;
            });

            $results[] = array_merge([
                'city' => $city,
                'coordinates' => [],
                'cached' => $cached,
            ], $result);
        }

        return Api::responseJson($results);
    }

}
