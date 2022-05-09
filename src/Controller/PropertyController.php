<?php

namespace App\Controller;


use Doctrine\ORM\Query;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Controller\PropertyController;
use App\Repository\PropertyRepository;
use App\Repository\ContactAIKRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class PropertyController extends Controller {


    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ContactAIKRepository
     */
    private $contactRepository;

    public function __construct( PropertyRepository $repository, ContactAIKRepository $contactRepository)
    {
        $this->repository = $repository;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/properties", name="properties")
     */
    
    public function Show_all(PaginatorInterface $paginator, Request $request){

        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $contact = $this->contactRepository->find(1);
        $properties = $paginator->paginate($this->repository->findAllQuery($search), $request->query->getInt('page',1), 12);
         return $this->render(
             '/garo/properties.html.twig' , [ 'contact' => $contact ,'properties' => $properties , 'form'  => $form->createView() ]
         );
     }

    /**
     * @Route("/buy", name="bproperties")
     */
    
    public function Buy(PaginatorInterface $paginator, Request $request){
        $contact = $this->contactRepository->find(1);
        $search = new PropertySearch();
        $search->setSituationS(1);
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        $properties = $paginator->paginate($this->repository->findAllQuery($search), $request->query->getInt('page',1), 12);
         return $this->render(
             '/garo/properties.html.twig' , [ 'contact' => $contact ,'properties' => $properties , 'form'  => $form->createView() ]
         );
     }

    /**
     * @Route("/rent", name="rproperties")
     */

    public function Rent(PaginatorInterface $paginator, Request $request ){
        $contact = $this->contactRepository->find(1);
        $search = new PropertySearch();
        $search->setSituationS(2);
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        $properties = $paginator->paginate($this->repository->findAllQuery($search), $request->query->getInt('page',1), 12);
        return $this->render(
            '/garo/properties.html.twig' , [ 'contact' => $contact ,'properties' => $properties , 'form'  => $form->createView() ]
        );
    }
    

    /**
     * @Route("/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */

    public function show (Request $request, PaginatorInterface $paginator, $slug, $id)
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $contact = $this->contactRepository->find(1);
        $property = $this->repository->find($id);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
        $properties = $paginator->paginate($this->repository->findAllQuery($search), $request->query->getInt('page',1), 12);
        return $this->redirectToRoute('properties' , $request->query->all());
        }

        return $this->render('/garo/property.html.twig',
        [
            'contact' => $contact ,
            'property' => $property,
            'form'  => $form->createView()
        ]
        );
    }
}


?>