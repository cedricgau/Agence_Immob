<?php
namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController{


    /**
 *@Route ("/", name="home")
 *@param PropertyRepository $repository
 *return Response  
 *@throws \Twig_Error_Loader
  *@throws \Twig_Error_Runtime
  *@throws \Twig_Error_Syntax 
 *
 */

    public function index(PropertyRepository $repository): Response {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', ['properties' => $properties]);
    }
}