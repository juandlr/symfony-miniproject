<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    private array $messages = [
        ['message' => 'Hello', 'created' => '2023/08/12'],
        ['message' => 'Hi', 'created' => '2023/07/12'],
        ['message' => 'Bye!', 'created' => '2021/05/12'],
    ];

    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $manager, MicroPostRepository $posts): Response
    {
        /*$user = new User();
        $user->setEmail('email@email.com');
        $user->setPassword('12345678');

        $profile = new UserProfile();
        $profile->setUser($user);
        $manager->persist($profile);
        $manager->flush();

        $profile = $profiles->find(1);
        $manager->remove($profile);
        $manager->flush();*/

        /*$post = new MicroPost();
        $post->setTitle('Hello');
        $post->setText('Hello');
        $post->setCreated(new \DateTime());*/


//        $post = $posts->find(15);
        /* $comment = new Comment();
        $comment->setText('Hello 1');
        $post->addComment($comment);*/

        /*$comment = $post->getComments()[0];
        $post->removeComment($comment);

        $manager->persist($post);
        $manager->flush();*/


        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => 3,
            ]
        );
    }


    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne($id): Response
    {
        return $this->render(
            'hello/show_one.html.twig',
            [
                'message' => $this->messages[$id],
            ]
        );
    }
}