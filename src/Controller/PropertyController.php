<?php
namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController{

/**
 * @var PropertyRepository
 */

    private $repository;

/**
*@var EntityManagerInterface
*/

    private $om;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $om) {
        $this->om = $om;
        $this->repository = $repository;
    }


/**
 * 
 * @Route("/biens", name="property.index" )
 * @return Response
 */

public function index(PaginatorInterface $paginator, Request $request): Response{

    # Saisi et enregistrement dans la base

    # $property = new Property();
    # $property->setTitle('Mon premier bien')
    #    ->setPrice(200000)
    #    ->setRooms(4)
    #    ->setBedrooms(3)
    #    ->setDescription('une petite description')
    #    ->setSurface(60)
    #    ->setFloor(1)
    #    ->setHeat(1)
    #    ->setCity('Montpellier')
    #    ->setAdress('15 Boulevard Gambetta')
    #    ->setPostalCode('34000');

    #    $em = $this->getDoctrine()->getManager();
    #    $em->persist($property);
    #    $em->flush();

    # Récupération des enregistrements dans la base
    # $property = $this->repository->findAllVisible();

    # Update exemple
    # $property[0]->setSold(true);
    #$this->om->flush();
    $properties = $paginator->paginate(
        $this->repository->findAllVisibleQuery(),
        $request->query->getInt('page', 1),12
    );
    return $this->render('property/index.html.twig', ['current_menu'=>'properties', 'properties' => $properties]);

}

/**
 * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug" : "[a-z0-9\-]*"})
 * @param Property $property
 * @return Response
 */

public function show(Property $property, string $slug): Response {
    if ($property->getSlug() !== $slug){
        return $this->redirectToRoute('property.show', ['id' => $property->getId(), 'slug' => $property->getSlug() ], 301);
    }
    return $this->render('property/show.html.twig', ['property' => $property , 'current_menu' => 'properties']);
}





}