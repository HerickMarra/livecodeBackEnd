<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/cpf', function (Request $request) {

    $entrada = $request->cpf . ",";
    $i = 0;
    $tmp = ""; 
    $cpfs = [];

    while (isset($entrada[$i])) {

        if ($entrada[$i] == ',') {

            $num = "";
            $j = 0;
            while (isset($tmp[$j])) {
                if ($tmp[$j] >= "0" && $tmp[$j] <= "9") {
                    $num .= $tmp[$j];
                }
                $j++;
            }

            $tamanho = 0;
            $j = 0;
            while (isset($num[$j])) { $tamanho++; $j++; }

            if ($tamanho < 11) {
                $faltam = 11 - $tamanho;

                while ($faltam > 0) {
                    $num = "0" . $num;
                    $faltam--;
                }
            }

            $mask = "";
            $j = 0;
            while (isset($num[$j])) {
                if ($j == 3 || $j == 6) {
                    $mask .= "." . $num[$j];
                } else if ($j == 9) {
                    $mask .= "-" . $num[$j];
                } else {
                    $mask .= $num[$j];
                }
                $j++;
            }

            array_push($cpfs, $mask);

            $tmp = "";
            $i++;
            continue;
        }

        $tmp .= $entrada[$i];
        $i++;
    }

    return response()
    ->json($cpfs)
    ->header('Access-Control-Allow-Origin', '*')
    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
    ->header('Access-Control-Allow-Methods', 'POST');
});
