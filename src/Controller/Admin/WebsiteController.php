<?php
namespace App\Controller\Admin;

use App\Form\ContactAIKType;
use App\Repository\ContactAIKRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebsiteController extends AbstractController
{
     /**
     * @var ContactAIKRepository
     */
    private $repository;
    public function __construct(ContactAIKRepository $repository , EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/website-settings", name="website")
     */
    public function index(Request $request, EntityManagerInterface $em) {

        $website = $this->repository->findAll()[0];
        $contact = $this->repository->find(1);
        
        $form = $this->createForm(ContactAIKType::class, $website);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           
            $em->persist($website);
            $em->flush();

            $this->addFlash(
                'success',
                "Your information has been updated successfully."
            );
        }

        return $this->render('/admin/website.html.twig', [
            'contact' => $contact ,
            'website' => $website,
            'form' => $form->createView()
        ]);
    }
}
