<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterProductController extends AbstractController
{
    /**
     * @Route("/registerProduct", name="registerProduct")
     */
    public function index(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        // Envio de formulario
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', Product::MESSAGE_SUCCESS);
            return $this->redirectToRoute('dashboardProductos');

        }

        return $this->render('register_product/index.html.twig', [
            'titlePage' => 'Formulario de registro de productos',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteProduct", options={"expose"=true}, name="deleteProduct")
     */
    public function deleteProduct(Request $request){

        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $id = $request->request->get('id');
            $delete = $em->getRepository(Product::class)->find($id);
            if(!$delete){
                throw $this->createNotFoundException('id no encontrado');
            }
            $em->remove($delete);
            $em->flush();
            
            return new JsonResponse(['delete'=>'yes']);
            
        }

    }
}
