<?php

namespace App\Service\AvatarFactory;



class Couleurs
{
    public static function randColor(int $couleur) : array
    {
        for($i =0; $i<$couleur; $i++){
            // $r = rand(0,255);
            // $g = rand(0,255);
            // $b = rand(0,255);
            
            $color[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        
        return $color;

    }
}