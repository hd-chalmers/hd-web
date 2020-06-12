<?php

namespace App\Http\Controllers;

use App\Http\Requests\BGGSearch;
use App\Lib\Api\BoardgameGeekAPIClient;
use Illuminate\Http\Request;

class BoardGameGeekController extends Controller
{
    private BoardgameGeekAPIClient $client;

    /**
     * BoardGameGeekController constructor.
     *
     */
    public function __construct()
    {
        $this->client = new BoardgameGeekAPIClient();
    }

    public function search(BGGSearch $request) {
        return $this->client->search($request);
    }

    public function fetch(int $id) {
        return $this->client->fetch($id);
    }

}
