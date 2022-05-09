<?php

namespace App\Controller;

use App\Controller\ContactController;
use App\Repository\PropertyRepository;
use App\Repository\ContactAIKRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ContactController extends Controller {


    /**
     * @var ContactAIKRepository
     */
    private $repository;

    public function __construct(ContactAIKRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/contact", name="contact")
     */
     public function contact(){
        $contact = $this->repository->find(1);
         return $this->render(
             'garo/contact.html.twig' 
         );
     }


    /**
     * @Route("/sell", name="sell")
     */
    
    public function Sell(){

        $contact = $this->repository->find(1);
        return $this->render('/garo/sell.html.twig', [

            'contact' => $contact
        ]);
    }

    /**
     * @Route("/other-services", name="other.services")
     */
    
    public function Other(){

        $contact = $this->repository->find(1);
        return $this->render('/garo/otherservices.html.twig', [

            'contact' => $contact
        ]);
    }
}

?>