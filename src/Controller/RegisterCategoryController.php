<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterCategoryController extends AbstractController
{
    /**
     * @Route("/registerCategory", name="registerCategory")
     */
    public function index(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        // Envio de formulario
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', Category::MESSAGE_SUCCESS);
            return $this->redirectToRoute('dashboardCategorias');

        }

        return $this->render('register_category/index.html.twig', [
            'titlePage' => 'Formulario de registro de categorias',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteCategory", options={"expose"=true}, name="deleteCategory")
     */
    public function deleteCategory(Request $request){

        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $id = $request->request->get('id');
            $delete = $em->getRepository(Category::class)->find($id);
            if(!$delete){
                throw $this->createNotFoundException('id no encontrado');
            }
            $em->remove($delete);
            $em->flush();
            
            return new JsonResponse(['delete'=>'yes']);
            
        }

    }

}
