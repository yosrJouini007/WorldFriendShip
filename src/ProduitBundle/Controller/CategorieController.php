<?php
/**
 * Created by PhpStorm.
 * User: Meriem
 * Date: 30/03/2019
 * Time: 16:56
 */

namespace ProduitBundle\Controller;


use ProduitBundle\Form\CategorieType;
use ProduitBundle\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategorieController extends Controller
{

    public function ajoutAction(Request $request)
    {
         $categorie = new Categorie();
         $form=$this->createForm(CategorieType::class,$categorie);
         $form->handleRequest($request);
         if($form->isSubmitted())
         {
             $em=$this->getDoctrine()->getManager();
             $categorie->uploadProfilePicture();
             $em->persist($categorie);
             $em->flush();

             return $this->redirectToRoute("produit_list");

         }

         return $this->render("ProduitBundle:Categorie:ajout.html.twig", array(
             'form'=>$form->createView()

         ));
    }

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("ProduitBundle:Categorie")->findAll();
        return $this->render("ProduitBundle:Categorie:list.html.twig",array('categories'=>$categories));
    }

    public function deleteAction(Request $request , $id)
    {

        $categorie = new Categorie();
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository("ProduitBundle:Categorie")->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("produit_list");
    }

    public function updateAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository("ProduitBundle:Categorie")->find($id);
        $form=$this->createForm(CategorieType::class,$categorie);
        if($form->isSubmitted())
        {
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute("produit_list");
        }
        return $this->render("ProduitBundle:Categorie:update.html.twig", array(
            'form'=>$form->createView()));
    }

    public function rechercheAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository("ProduitBundle:Categorie")->findAll();
        if($request->isMethod('POST'))
        {
            $libelle=$request->get('libelle');
            $categories=$em->getRepository("ProduitBundle:Categorie")->findBy(array("libelle"=>$libelle));
        }
        return $this->render("ProduitBundle:Categorie:rech.html.twig", array('categories'=>$categories));

    }
}