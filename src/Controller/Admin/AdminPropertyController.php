<?php
namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use App\Repository\ContactAIKRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class AdminPropertyController extends Controller
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ContactAIKRepository
     */
    private $contactRepository;

    public function __construct( ContactAIKRepository $contactRepository , PropertyRepository $repository , EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */

    public function index(PaginatorInterface $paginator, Request $request)
    {
        $contact = $this->contactRepository->find(1);
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        $properties = $paginator->paginate($this->repository->findAllQuery($search), $request->query->getInt('page',1), 12);
        return $this->render('/admin/property/index.html.twig', [
            'contact' => $contact ,
            'properties' => $properties ,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/admin-property-create", name="admin.property.new")
     */
    public function new( Request $request)
    {
        $contact = $this->contactRepository->find(1);
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $images =$form->get('images')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setName($fichier);
                $property->addImage($img);
            }

            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Property has been Created sussessfully');
            return $this->redirectToRoute('admin.property.index');
        }
            return $this->render('/admin/property/new.html.twig', [
            'contact' => $contact ,
            'property' => $property,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin-{id}", name="admin.property.edit", methods="GET|POST")
     */

    public function edit(Property $property , Request $request)
    {
        $contact = $this->contactRepository->find(1);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $images =$form->get('images')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setName($fichier);
                $property->addImage($img);
            }
            $this->em->flush();
            $this->addFlash('success','Property has been Edited sussessfully');
            return $this->redirectToRoute('admin.property.index');
        }
            return $this->render('/admin/property/edit.html.twig', [
            'contact' => $contact ,
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    
    /**
     * @Route("/admin-{id}", name="admin.property.delete", methods="DELETE")
     */

    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token')))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Property has been Deleted sussessfully');
        }
        return $this->redirectToRoute('admin.property.index');
    }
    
    /**
     * @Route("/admin-delete-image/{id}", name="property.delete.image", methods={"DELETE"})
     */

     public function deleteImage(Images $image, Request $request){
         $data = json_decode($request->getContent(), true);
         if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token']))
         {
            $nom = $image->getName();
            unlink($this->getParameter('images_directory').'/'.$nom);

            $this->em->remove($image);
            $this->em->flush();

            return new JsonResponse(['success' => 1]);
         }
         else {
             return new JsonResponse(['error' => 'Token Invalide'], 400);
         }
     }

}