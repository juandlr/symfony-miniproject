<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
            'posts' => $posts->findAllWithComments(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    #[IsGranted(MicroPost::VIEW, 'post')]
    public function showOne(MicroPost $post): Response
    {
//        dd($post);
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[IsGranted('ROLE_WRITER')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(MicroPostType::class, new MicroPost());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setAuthor($this->getUser());
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
    #[IsGranted(MicroPost::EDIT, 'post')]
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
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
    #[IsGranted('ROLE_COMMENTER')]
    public function addComment(MicroPost $post, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());
        $form->handleRequest($request);
//        dd($post);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $manager->persist($comment);
            $manager->flush();

            // Add a flash
            $this->addFlash('success', 'Your comment has been posted.');

            // Redirect
            return $this->redirectToRoute(
                'app_micro_post_show',
                ['post' => $post->getId()]
            );
        }

        return $this->renderForm('micro_post/comment.html.twig', [
            'form' => $form,
            'post' => $post,
        ]);
    }
}
