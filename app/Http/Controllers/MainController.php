<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
		private $fourSquareCreds = array(
			'client_id' => 'UEX3CSLZRS3HP3T4MF4DQSO3ZHBV2BOFD35V2KOJHCUEC5AW',
			'client_secret' => 'ANC0XWBMZ4EQEHRMFC3SLEX3KPZKA3DHF4VUL5HAUDEP5GFZ'
		);

		private $weatherMapApiKey = 'cf6274acd4f0b43df698ba19cb7704e3';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

		public function index()
		{
			//
		}

		public function getVenueDetails($query)
		{
			$data = [];
			
			$venueInfo = $this->fourSquareAPI($query)['response'];

			foreach($venueInfo['venues'] as $venueKey => $venueVal){
				$subArray = array(
					'name' => $venueVal['name'],
					'location' => $venueVal['location'],
					'city' => $this->weatherMapAPI($venueVal['location']['lat'],$venueVal['location']['lng'])['city']['name'],
					'weather' => number_format($this->weatherMapAPI($venueVal['location']['lat'],$venueVal['location']['lng'])['list'][0]['main']['temp'] - 273.15, 2). '°C'.', '.
					ucwords($this->weatherMapAPI($venueVal['location']['lat'],$venueVal['location']['lng'])['list'][0]['weather'][0]['description'])
				);
				$data['data'][] = $subArray;
			}

			return $data;
		}

    public function fourSquareAPI($queryParam)
    {
			$data = [];
			$data = Http::get('https://api.foursquare.com/v2/venues/search?client_id='.$this->fourSquareCreds['client_id'].'&client_secret='.$this->fourSquareCreds['client_secret'].'&near=Japan&query='.$queryParam.'&v=20210301')->json();

			return $data;
    }

		public function weatherMapAPI($lat, $lng){
			$data = [];
			//$data = Http::get('https://api.openweathermap.org/data/2.5/forecast?q='.$queryCity.',Japan&appid='.$this->weatherMapApiKey)->json();
			$data = Http::get('api.openweathermap.org/data/2.5/forecast?lat='.$lat.'&lon='.$lng.'&appid='.$this->weatherMapApiKey)->json();

			return $data;
		}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
