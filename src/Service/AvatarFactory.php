<?php

namespace App\Service;



use App\Service\AvatarFactory\AvatarMatrix;
use App\Service\AvatarFactory\Svg;

class AvatarFactory
{
    public function showAvatar(int $size, int $color)
    {
        $avatar = new AvatarMatrix($size, $color);
        $svgModel= new Svg(200,200);
        $svg =$svgModel->show($avatar);

        return $svg;

    }
}