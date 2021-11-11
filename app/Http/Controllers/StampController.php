<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;

class StampController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' =>['stamp']]);
    }

    public function stamp(Request $request)
    {
        $id_file = File::save_picture($request->file);
        
        $path = File::get_path($id_file);

        $hash = hash_file('sha256', $path);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://tsa2.buenosaires.gob.ar:443/stamp");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"hashes\":[\"$hash\"]}");

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return redirect()->route('stamp')->with('status', 'El archivo fue sellado con éxito.');
    }

    public function check(Request $request)
    {
        $id_file = File::save_picture($request->file);
        
        $path = File::get_path($id_file);

        $hash = hash_file('sha256', $path);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://tsa2.buenosaires.gob.ar:443/verify/$hash");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }
        else {
            $json_result = json_decode($result);

            if($json_result->stamped == false){
                return redirect()->route('check')->with('message-error', 'El archivo NO fue sellado aún.');
            }

            return redirect()->route('check')->with('status', 'El archivo fue sellado con éxito. Nodo sellador: '.$json_result->stamps[0]->whostamped.'. Numero de bloque: '. $json_result->stamps[0]->blocknumber . '. Fecha: '. date( "d-m-Y h:i:s A", $json_result->stamps[0]->blocktimestamp) );
        }

        curl_close($ch);
    }
}
