<?php

namespace App\Controller;

use App\Form\SvgType;
use App\Service\AvatarFactory;
use App\Service\AvatarFactory\AvatarMatrix;
use App\Service\AvatarFactory\Svg;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SvgController extends AbstractController
{
    #[Route('/svg', name: 'app_svg')]
    public function avatarGen(Request $request, AvatarFactory $avatarFactory){

        $form = $this->createForm(SvgType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taille = $form->get('taille')->getData();
            $color = $form->get('couleur')->getData();
            $svg = $avatarFactory->showAvatar($taille, $color);
            return new Response($svg);
        }

/*        if (!empty($_POST)) {

            $couleurs = strip_tags(trim($_POST['couleur']));
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
        }*/


    }

}