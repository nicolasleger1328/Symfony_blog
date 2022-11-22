<?php

namespace App\Controller;

use App\Form\SvgType;
use App\Form\UserType;
use App\Service\AvatarFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function edit( AvatarFactory $avatarFactory): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $svg= $avatarFactory->showAvatar(AvatarFactory\AvatarMatrix::DEFAULT_SIZE, AvatarFactory\AvatarMatrix::DEFAULT_SIZE);

        $formAvatar = $this->createForm(SvgType::class, null, [
            'attr'=>[
                'class' => 'svgForm'
            ]
        ]);

        $form = $this->createForm(UserType::class, $user);

        return $this->renderForm('user/index.html.twig', [
            'user' => $user,
            'form' => $form,
            'svg' => $svg,
            'formAvatar' => $formAvatar
        ]);
/*        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);*/
    }
}
