<?php

namespace Seat\Kassie\Calendar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Seat\Eveapi\Models\Account\ApiKeyInfoCharacters;
use Seat\Web\Http\Controllers\Controller;

class LookupController extends Controller
{

	public function lookupCharacters(Request $request)
	{
		$characters = ApiKeyInfoCharacters::where('characterName', 'LIKE', '%' . $request->input('query') . '%')->take(5)->get()->unique('characterID');

		$results = array();

		foreach ($characters as $character) {
			array_push($results, array(
				"value" => $character->characterName, 
				"data" => $character->characterID
			));
		}

		return response()->json(array('suggestions' => $results));
	}

	public function lookupSystems(Request $request)
	{
		$systems = DB::table('invUniqueNames')->where([
			['groupID', '=', 5],
			['itemName', 'like', $request->input('query') . '%']
		])->take(10)->get();

		$results = array();

		foreach ($systems as $system) {
			array_push($results, array(
				"value" => $system->itemName, 
				"data" => $system->itemID
			));
		}

		return response()->json(array('suggestions' => $results));
	}

}