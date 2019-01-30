<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\Post;
use App\Entity\Repository\PostRepository;
use App\Form\AddType;
use App\Entity\User;
use App\Form\RegistrationType;

class AdminController extends AbstractController
{
    /**
     * @Route("/list", name="admin_list")
     */
    public function list(){
        $posts= new Post();
        $repo=$this->getDoctrine()->getRepository(Post::class);
        $posts=$repo->findAll();
        return $this->render('admin/list.html.twig',[
            'posts'=>$posts
        ]);
    }  
    /**
     * @Route("/addUpdate", name="admin_addUpdate")
     * @Route("/addUpdate/{id}/edit", name="admin_addUpdateEdit")
     */
    public function add(Post $post=null, Request $request, ObjectManager $manager){
        if(!$post){
            $post= new Post();
        }
        $form=$this->createForm(AddType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$post->getId()){
                $post->setCreatedAt(new \DateTime());
            }
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('admin_list');
        }
        return $this->render('admin/addUpdate.html.twig',[
            'formAdd'=>$form->createView(),
            'editMode'=>$post->getId()!==null
        ]);
    }
     /**
      * @Route("/list/{id}", name="admin_delete")
      */
    public function delete($id, ObjectManager $manager){
        $post = new Post();
        $repo=$this->getDoctrine()->getRepository(Post::class);
        $post=$repo->find($id);
        $manager->remove($post);
        $manager->flush();
        return $this->redirectToRoute('admin_list');
        return $this->render('admin/delete.html.twig');
    } 
    
}
