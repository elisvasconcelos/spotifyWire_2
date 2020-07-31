<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SpotifyResults extends Component
{
	protected $listeners = ['search' => 'searchSpotify'];
	public $result = [];

	//realizar busca na API
    public function search()
    {   	
    	$auth = Http::withHeaders([
		  'Authorization' => 'Basic YTViNDM0MDE2MDEzNGFlZmExM2IzMWUzNDA5NzVlYjA6ZTk3NmUyNGY2NTcxNDQ0NTliZmNkMjlmOTlmNjY3OTM='
    	])->asForm()->post('https://accounts.spotify.com/api/token', [
        	'grant_type' => 'client_credentials',
    	]);
    	$obj = $auth->json();
    	$token = $obj['access_token'];
    	
      	$busca = Request::get('busca');
      	$response = Http::withHeaders([
        	'Authorization' => 'Bearer '.$token,
    	])->get('https://api.spotify.com/v1/search?', [
        	'q' => $busca,
        	'type' => 'track',
    	]);

    	$resp = $response->json();

        $this->result = $resp;
    }

    public function render()
    {
        return view('livewire.spotify-results', [ 'musicas' => $this->result]);
    }
}
