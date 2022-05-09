<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Controller\HomeController;
use App\Repository\PropertyRepository;
use App\Repository\ContactAIKRepository;
use App\Repository\TestimanialRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller {

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ContactAIKRepository
     */
    private $contactRepository;

    /**
     * @var TestimanialRepository
     */
    private $testimanialRepository;

    public function __construct( TestimanialRepository $testimanialRepository, PropertyRepository $repository, ContactAIKRepository $contactRepository)
    {
        $this->repository = $repository;
        $this->testimanialRepository = $testimanialRepository;
        $this->contactRepository = $contactRepository;
    }
    
    /**
     * @Route("/", name="homepage")
     */
     public function home(TestimanialRepository $testimanialRepository, PropertyRepository $repository, Request $request, PaginatorInterface $paginator){
        $latest4 = $repository->findLatest(4);
        $latest7 = $repository->findLatest(7);
        $testimanials = $testimanialRepository->findAll();
        $search = new PropertySearch();
        $contact = $this->contactRepository->find(1);
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
        $properties = $paginator->paginate($this->repository->findAllQuery($search), $request->query->getInt('page',1), 12);
        return $this->redirectToRoute('properties' , $request->query->all());
        }
        
        $properties = $this->repository->findAllQuery($search);
        return $this->render('/garo/index.html.twig', [
            'properties' => $properties ,
            'testimanials' => $testimanials ,
            'latest4' => $latest4 ,
            'latest7' => $latest7 ,
            'contact' => $contact ,
            'form'  => $form->createView()
        ]);}
}

?>