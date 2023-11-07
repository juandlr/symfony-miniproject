<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    private array $messages = [
        ['message' => 'Hello', 'created' => '2023/08/12'],
        ['message' => 'Hi', 'created' => '2023/07/12'],
        ['message' => 'Bye!', 'created' => '2021/05/12']
    ];

    #[Route('/{limit?3}', name: 'app_index')]
    public function index(int $limit): Response {
        return $this->render(
            'hello/index.html.twig',
            [
                'messages' =>  $this->messages,
                'limit' => $limit
            ]
        );
    }


    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne($id): response {
        return $this->render(
            'hello/show_one.html.twig',
            [
                'message' => $this->messages[$id],
            ]
        );
    }
}