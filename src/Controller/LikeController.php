<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(MicroPost $post, Request $request, EntityManagerInterface $manager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $post->addLikedBy($user);
        $manager->persist($post);
        $manager->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/unlike/{id}', name: 'app_unlike')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function unlike(MicroPost $post, Request $request, EntityManagerInterface $manager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $post->removeLikedBy($user);
        $manager->persist($post);
        $manager->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
