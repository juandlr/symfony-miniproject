<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowerController extends AbstractController
{
    #[Route('/follower/{id}', name: 'app_follow')]
    public function follow(
        User $userToFollow,
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($userToFollow->getId() !== $currentUser->getId()) {
            $currentUser->follow($userToFollow);
            $manager->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/unfollow/{id}', name: 'app_unfollow')]
    public function unfollow(
        User $userToUnfollow,
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($userToUnfollow->getId() !== $currentUser->getId()) {
            $currentUser->unfollow($userToUnfollow);
            $manager->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }
}