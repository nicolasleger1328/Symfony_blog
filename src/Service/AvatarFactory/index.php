<?php
require_once 'vendor/autoload.php';
include_once 'AvatarMatrix.php';
include_once 'SvgAvatarRenderer.php';



if (!empty($_POST)) {

    $couleurs = strip_tags(trim($_POST['couleurs']));
    $taille = strip_tags(trim($_POST['taille']));
    $avatar = new AvatarMatrix($couleurs, $taille);
    $svgModel= new Svg(200,200);
    $svg = $svgModel->show($avatar);
    // $svg = AvatarFactory::new($couleurs, $taille);

}else{
    $avatar = new AvatarMatrix();
    $svgModel= new Svg(200,200);
    $svg = $svgModel->show($avatar);
    // $svg = AvatarFactory::new();
}
if(empty($_GET)) {
    require 'home.phtml';
}else{

    echo $svg;
}



