<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;



class PropertyController extends AbstractController{


/**
 * 
 * @Route("/biens", name="property.index" )
 * @return Response
 */

public function index(): Response{

    $property = new Property();
    $property->setTitle('Mon premier bien')
        ->setPrice(200000)
        ->setRooms(4)
        ->setBedrooms(3)
        ->setDescription('une petite description')
        ->setSurface(60)
        ->setFloor(1)
        ->setHeat(1)
        ->setCity('Montpellier')
        ->setAdress('15 Boulevard Gambetta')
        ->setPostalCode('34000');
        
    return $this->render('property/index.html.twig', ['current_menu'=>'properties']);

}





}