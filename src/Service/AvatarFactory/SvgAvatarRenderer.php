<?php

namespace App\Service\AvatarFactory;


class Svg
{

    private int $height;
    private int $width;

    public function __construct($height=300, $width=300)
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function show($avatar): string
    {

        $svg = '<svg width="'.$this->width.'" height="'.$this->height.'" viewBox="0 0 '.($avatar->getTaille()).' '.($avatar->getTaille()).'" version="1.1" baseProfile="full" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ev="http://www.w3.org/2001/xml-events">';
        foreach($avatar->getMatrix() as $keyY => $ligne){
            
            foreach($ligne as $keyX => $objet){
            $svg.= '<rect x="'.$keyX.'" y="'.$keyY.'" width="1" height="1"  fill="'.$objet.'" />';
            /*$svg.=  '<circle cx="'.$keyX+0.5.'" cy="'.$keyY+0.5.'" r="0.5" stroke="'.$objet.'" />';*/
            }
        }

        $svg .= '</svg>';

        return $svg;

    }
}