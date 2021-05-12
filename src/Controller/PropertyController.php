<?php
namespace App\Controller;



use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
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

    // Créer une entité qui va représenter notre recherche
    //Créer un formulaire
    $search = new PropertySearch();
    $form = $this->createForm( PropertySearchType:: class, $search);
    $form->handleRequest($request);
    //Gérer le traitement dans le controller
    
    $properties = $paginator->paginate(
        $this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page',1),12
    );
    return $this->render('property/index.html.twig', ['current_menu'=>'properties', 'properties' => $properties, 'form' => $form->createView() ]);

}

/**
 * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug" : "[a-z0-9\-]*"})
 * @param Property $property
 * @return Response
 */

public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response {

    if ($property->getSlug() !== $slug){
        return $this->redirectToRoute('property.show', ['id' => $property->getId(), 'slug' => $property->getSlug() ], 301);
    }

    $contact = new Contact();
    $contact->setProperty($property);
    $form = $this->createForm( ContactType::class, $contact);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $notification->notify($contact);
        $this->addFlash('success','Votre email a bien été envoyé');
        return $this->redirectToRoute('property.show', ['id' => $property->getId(), 'slug' => $property->getSlug() ]);
    }

    return $this->render('property/show.html.twig', ['property' => $property, 'current_menu' => 'properties', 'form' => $form->createView() ]);
}





}