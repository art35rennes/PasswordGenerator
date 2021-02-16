<?php

namespace App\Http\Controllers;

use Faker\Factory;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function home()
    {
        $faker = Factory::create();
        if (Cookie::has("seed")){
            $seed = Cookie::get("seed");
        }else{

            $seed = Str::slug($faker->sentence(1, false));
            Cookie::queue("seed", $seed);
        }
        $faker->seed($this->stringToInt($seed));

        $keyboard = [
            "a"=>null, "b"=>null, "c"=>null, "d"=>null, "e"=>null, "f"=>null,
            "g"=>null, "h"=>null, "i"=>null, "j"=>null, "k"=>null, "l"=>null,
            "m"=>null, "n"=>null, "o"=>null, "p"=>null, "q"=>null, "r"=>null,
            "s"=>null, "t"=>null, "u"=>null, "v"=>null, "w"=>null, "x"=>null,
            "y"=>null, "z"=>null, "."=>null, "/"=>null, "-"=>null, "_"=>null,
            "+"=>null,
        ];
        $rndArray = [
            "A", "B", "C", "D", "E", "F","G", "H", "I", "J", "Q", "L","M", "N", "O", "P", "K", "R","S", "T", "U", "V", "W", "X","Y", "Z",
            "a", "b", "c", "d", "e", "f","g", "h", "i", "j", "q", "l","m", "n", "o", "p", "k", "r","s", "t", "u", "v", "w", "x","y", "z",
            '+',"*","-","#","@","&","$","!","%",".","(",")",
            "0","1","2","3","4","5","6","7","8","9",
        ];

        srand($this->stringToInt($seed));
        foreach ($keyboard as $key=>$value){
            $rnd = array_rand($rndArray, 1);
            $pop = $rndArray[$rnd];
            unset($rndArray[$rnd]);
            $keyboard[$key] = $pop;
        }
        return Response::view("welcome", ["keyboard"=>$keyboard, "seed"=>$seed, "password"=>$faker->password(6,6)]);
    }

    private function stringToInt($string){
        $int = 1;
        for ($i=0; $i<Str::length($string); $i++){
            $int *= ord($string[$i]);
        }

//        dd($string, $int);
        return intval($int);
    }
}
