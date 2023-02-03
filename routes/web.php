<?php

use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $aOutput = [];

    try {
        $sData = File::get('data.json');
        $aData = json_decode($sData, true);
        if ($aData === null) {
            echo("Unable to extract data! Please choose a data with correct format.");
            die();
        }
    } catch (\Exception $exception) {
        echo("Unable to extract data! Please choose a data with correct format.");
        die();
    }

    foreach($aData as $sValue) {
        $oClient = new Client();
        $oResponse = $oClient->request('GET', $sValue);
        echo '"'.$sValue.'"' . ' => ' . $oResponse->getStatusCode() . '<br>';
        array_push($aOutput, ['URL' => $sValue, 'Response' => $oResponse->getStatusCode()]);
    }

    dd($aOutput);
});
