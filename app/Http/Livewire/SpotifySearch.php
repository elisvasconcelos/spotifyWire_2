<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SpotifySearch extends Component
{
	public $search = '';
    public $readyToLoad = false;

    protected $listeners = ['search' => 'search'];

    public function render()
    {
        return view('livewire.spotify-search', [ 'musicas' => $this->readyToLoad
                ? SpotifyResults::search()
                : [],]);
    }

    public function search()
    {
    	$this->validate([
            'search' => 'required|min:',
        ]);

        $this->readyToLoad = true;

    	$this->emit('search');

    	$auth = Http::withHeaders([
		  'Authorization' => 'Basic YTViNDM0MDE2MDEzNGFlZmExM2IzMWUzNDA5NzVlYjA6ZTk3NmUyNGY2NTcxNDQ0NTliZmNkMjlmOTlmNjY3OTM='
    	])->asForm()->post('https://accounts.spotify.com/api/token', [
        	'grant_type' => 'client_credentials',
    	]);
    	$obj = $auth->json();
    	$token = $obj['access_token'];
    	
      	$response = Http::withHeaders([
        	'Authorization' => 'Bearer '.$token,
    	])->get('https://api.spotify.com/v1/search?', [
        	'q' => $this->search,
        	'type' => 'track',
    	]);

    	$resp = $response->body();

        return $resp;
    }
}
