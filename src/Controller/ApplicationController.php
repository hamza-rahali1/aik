<?php
namespace App\Controller;

use App\Entity\Property;
use App\Entity\ContactAIK;
use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\UserRepository;
use App\Repository\ContactAIKRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ApplicationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApplicationController extends AbstractController
{
     /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var ApplicationRepository
     */
    private $applicationRepository;

    /**
     * @var ContactAIKRepository
     */
    private $contactRepository;

    public function __construct(UserRepository $repository, ContactAIKRepository $contactRepository , ApplicationRepository $applicationRepository,EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $repository;
        $this->applicationRepository = $applicationRepository;
        $this->contactRepository = $contactRepository;
       
    }


    /**
     * @Route("/applications", name="applications")
     */
    
    public function Show_all(PaginatorInterface $paginator, Request $request){
        $app = $this->applicationRepository->findAll();
        $contact = $this->contactRepository->find(1);
        $applications = $paginator->paginate($app, $request->query->getInt('page',1), 12);

        return $this->render('/admin/applications.html.twig', [
            'contact' => $contact ,

            'applications' => $applications
        ]);
    }

    /**
     * @Route("/application-check-{id}", name="application.check")
     */
    
    public function Check(Application $application, EntityManagerInterface $em){

        if ($application->getChecked() == true )
        {
            $application->setChecked(false) ; 
        }
        else{
            $application->setChecked(true)  ;
        }

        $em->persist($application);
        $em->flush();

            return $this->redirectToRoute('applications');
    }



    /**
     * @Route("/application-{id}", name="application.show", methods="GET|POST")
     */
    
    public function Show(Application $application){
        $contact = $this->contactRepository->find(1);
        return $this->render('/admin/applicationshow.html.twig', [
            'contact' => $contact ,

            'application' => $application
        ]);
    }


    

    /**
     * @Route("/application-delete-{id}", name="application.delete", methods="DELETE")
     */

    public function deleteApplication( Application $application, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$application->getId(), $request->get('_token')))
        {
            $this->em->remove($application);
            $this->em->flush();
            $this->addFlash('success','messsage has been Deleted sussessfully');
        }
        return $this->redirectToRoute('applications');
    }


    /**
     * @Route("/application_form-{id}", name="apply_property" , methods="GET|POST")
     */
    public function apply_property(Property $property ,Request $request, EntityManagerInterface $em) {

        $application = new Application();
        
        $form = $this->createForm(ApplicationType::class, $application, array('user' => $this->getUser()));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           if ($this->getUser()){
            $application->setFirstName($this->getUser()->getFirstName());
            $application->setLastName($this->getUser()->getLastName());
            $application->setPhone($this->getUser()->getPhone());
            $application->setEmail($this->getUser()->getEmail());
            $application->setOtherEmail($this->getUser()->getOtherEmail());
            $application->setApplicant($this->getUser());
            $application->setProperty($property);

            $em->persist($application);
            $em->flush();
           }
           else {
            $em->persist($application);
            $em->flush();
           }

            $this->addFlash(
                'success',
                "Your application has been sended successfully."
            );
        }
        $contact = $this->contactRepository->find(1);
        return $this->render('/garo/application.html.twig', [
            'contact' => $contact ,
            'user' => $this->getUser(),
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/application_form", name="apply")
     */
    public function apply(Request $request, EntityManagerInterface $em) {

        $application = new Application();
        
        $form = $this->createForm(ApplicationType::class, $application, array('user' => $this->getUser()));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           if ($this->getUser()){
            $application->setFirstName($this->getUser()->getFirstName());
            $application->setLastName($this->getUser()->getLastName());
            $application->setPhone($this->getUser()->getPhone());
            $application->setEmail($this->getUser()->getEmail());
            $application->setOtherEmail($this->getUser()->getOtherEmail());
            $application->setApplicant($this->getUser());

            $em->persist($application);
            $em->flush();
           }
           else {
            $em->persist($application);
            $em->flush();
           }

            $this->addFlash(
                'success',
                "Your application has been sended successfully."
            );
        }
        $contact = $this->contactRepository->find(1);
        return $this->render('/garo/application.html.twig', [
            'contact' => $contact ,
            'user' => $this->getUser() ,
            'form' => $form->createView()
        ]);
    }
}
