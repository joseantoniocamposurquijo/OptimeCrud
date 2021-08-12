<?php

namespace App\Controller;

use App\Entity\Product;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardProductosController extends AbstractController
{
    /**
     * @Route("/", name="dashboardProductos")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // Traer todos los registros de la base de datos
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Product::class)->BuscarProductos();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('dashboard_productos/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
