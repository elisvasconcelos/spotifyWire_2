<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spotify extends Model
{
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

    	return $resp;
    }
}
