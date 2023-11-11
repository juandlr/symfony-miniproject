<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(EntityManagerInterface $manager, MicroPostRepository $posts): Response
    {
//        dd($posts->findAll());
//        $microPost = new MicroPost();
//        $microPost->setTitle('It comes from controller');
//        $microPost->setText('Hi!');
//        $microPost->setCreated(new \DateTime());

        // save
//        $manager->persist($microPost);
//        $manager->flush();

        // update
//        $microPost = $posts->find(3);
//        $microPost->setTitle('Welcome in General!');
//        $manager->flush();

        // remove
//        $manager->remove($microPost);
//        $manager->flush();


        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
//        dd($post);
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreated(new \DateTime());
            $manager->persist($post);
            $manager->flush();

            // Add a flash
            $this->addFlash('success', 'Your micro post have been added');

            // Redirect
            return $this->redirectToRoute('app_micro_post');

        }

        return $this->renderForm('micro_post/add.html.twig', [
                'form' => $form,
            ]);
    }

    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(MicroPost $post, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(MicroPostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $manager->persist($post);
            $manager->flush();

            // Add a flash
            $this->addFlash('success', 'Your micro post have been updated');

            // Redirect
            return $this->redirectToRoute('app_micro_post');

        }

        return $this->renderForm('micro_post/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
