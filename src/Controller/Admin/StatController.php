<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use App\Repository\PropertyRepository;
use App\Repository\ContactAIKRepository;
use App\Repository\ApplicationRepository;
use App\Repository\TestimanialRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatController extends AbstractController
{
     /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ApplicationRepository
     */
    private $applicationRepository;

    /**
     * @var TestimanialRepository
     */
    private $testimanialRepository;

    /**
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * @var ContactAIKRepository
     */
    private $contactRepository;

    public function __construct( ContactAIKRepository $contactRepository ,PropertyRepository $propertyRepository, UserRepository $userRepository, ApplicationRepository $applicationRepository, TestimanialRepository $testimanialRepository, MessageRepository $messageRepository )
    {
        $this->propertyRepository = $propertyRepository;
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
        $this->testimanialRepository = $testimanialRepository;
        $this->messageRepository = $messageRepository;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/statistiques", name="stat")
     */
    public function index()
    {
        $contact = $this->contactRepository->find(1);
        $usersNB = count ($this->userRepository->findAll());
        $clientNB = count ($this->userRepository->findBy(array('roles' => 'ROLE_USER')));
        $agentNB = count ($this->userRepository->findBy(array('roles' => 'ROLE_AGENT')));
        $adminNB = count ($this->userRepository->findBy(array('roles' => 'ROLE_ADMIN')));

        $properties = $this->propertyRepository->findAll();
        $propertiesNB = count ($properties);
        $sellNB = count ($this->propertyRepository->findBy(array('situation' => '1')));
        $rentNB = count ($this->propertyRepository->findBy(array('situation' => '2')));
        $justSoldNB = count ($this->propertyRepository->findBy(array('situation' => '3')));

        $appsNB = count ($this->applicationRepository->findAll());
        $testimanialsNB = count ($this->testimanialRepository->findAll());

        $favorisNB = 0;
        $applicationsNB = 0;
        foreach ($properties as $property){
            if($property->getUsers()->count() != 0){
                $favorisNB = $favorisNB + 1 ;
            }
        }

        foreach ($properties as $property){
            if($property->getApplications()->count() != 0){
                $applicationsNB = $applicationsNB + 1 ;
            }
        }

        


        return $this->render('/admin/stat.html.twig', [
            'contact' => $contact ,
            'usersNB' => $usersNB ,
            'clientNB' => $clientNB ,
            'agentNB' => $agentNB ,
            'adminNB' => $adminNB ,

            'propertiesNB' => $propertiesNB ,
            'sellNB' => $sellNB ,
            'rentNB' => $rentNB ,
            'justSoldNB' => $justSoldNB ,

            'favorisNB' => $favorisNB ,
            'applicationsNB' => $applicationsNB ,
            'appsNB' => $appsNB ,
            'testimanialsNB' => $testimanialsNB ,
        ]);
    }
}
