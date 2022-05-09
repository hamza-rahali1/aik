<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use App\Repository\ContactAIKRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TestimanialRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommController extends Controller
{

    /**
     * @var MessageRepository
     */
    private $repositoryMessage;

    /**
     * @var TestimanialRepository
     */
    private $repositoryTestimanial;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var ContactAIKRepository
     */
    private $contactRepository;
   

    public function __construct(ContactAIKRepository $contactRepository ,UserRepository $repository ,TestimanialRepository $repositoryTestimanial, MessageRepository $repositoryMessage , EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->repositoryMessage = $repositoryMessage;
        $this->repositoryTestimanial = $repositoryTestimanial;
        $this->em = $em;
        $aikMail = new User();
        $aikMail = $this->repository->find($id=1);
        $this->aikMail = $aikMail;
        $this->contactRepository = $contactRepository;
    }
    
    /**
     * @Route("/communications", name="communications")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $contact = $this->contactRepository->find(1);

        $needAnswer = $this->repository->findBy(
            ['roles' => 'ROLE_USER',
            'answered' => false]
        );

        $notAnswered = $paginator->paginate($needAnswer, $request->query->getInt('page',1), 4);

        return $this->render('/admin/comm.html.twig', [
            'contact' => $contact ,

            'notAnswered' => $notAnswered
        ]);
    }
}
