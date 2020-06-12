<?php


namespace App\Lib\Api;


use App\Http\Requests\BGGSearch;
use GuzzleHttp\Client;

class BoardgameGeekAPIClient
{
    private Client $client;

    /**
     * BoardgameGeekAPIClient constructor.
     *
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://boardgamegeek.com/xmlapi2/']);
    }


    public function search(BGGSearch $request)
    {
        $query = [
            'query' => str_replace(' ', '+', trim($request->input('query'))),
            'type'  => $request->input('type') !== 'all' ? $request->input('type') : '',
            'exact' => $request->input('exact') ? 1 : '',
        ];

        $res = $this->client->get('search', ['query' => $query]);

        $res = \GuzzleHttp\json_decode(\GuzzleHttp\json_encode(simplexml_load_string((string)$res->getBody())), TRUE);


        $items = [];
        if (isset($res['item']['name'])) {
            $item    = $res['item'];
            $items[] = [
                'type'           => $item['@attributes']['type'],
                'id'             => $item['@attributes']['id'],
                'name'           => $item['name']['@attributes']['value'],
                'published_year' => $item['yearpublished']['@attributes']['value'],
            ];
        } else {
            if (($res['@attributes']['total'] ?? 0) > 0) {
                foreach ($res['item'] as $item) {
                    $items[] = [
                        'type'           => $item['@attributes']['type'],
                        'id'             => $item['@attributes']['id'],
                        'name'           => $item['name']['@attributes']['value'],
                        'published_year' => $item['yearpublished']['@attributes']['value'] ?? '0000',
                    ];
                }
            }
        }

        return \GuzzleHttp\json_encode([
                                           'total' => $res['@attributes']['total'] ?? -1,
                                           'items' => $items,
                                       ]);
    }

    public function fetch(int $id)
    {
        $query = [
            'id' => $id,
        ];

        $res = $this->client->get('thing', ['query' => $query]);

        $res = \GuzzleHttp\json_decode(\GuzzleHttp\json_encode(simplexml_load_string((string)$res->getBody())), TRUE);

        return $res['item'];
    }
}
