<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Message;
use App\Form\AccountType;
use App\Form\MessageType;
use App\Entity\UserSearch;
use App\Form\UserSearchType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use App\Repository\ContactAIKRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class UsersManagerController extends Controller
{

    
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var MessageRepository
     */
    private $repositoryMessage;

    /**
     * @var ContactAIKRepository
     */
    private $contactRepository;

    public function __construct( ContactAIKRepository $contactRepository ,MessageRepository $repositoryMessage ,UserRepository $repository , EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $repository;
        $this->repositoryMessage = $repositoryMessage;
        $this->contactRepository = $contactRepository;       
    }
    /**
     * @Route("/users_manager", name="users_manager")
     */

    public function index(PaginatorInterface $paginator, Request $request)
    {
        $contact = $this->contactRepository->find(1);
        $search = new UserSearch();

        $form = $this->createForm(UserSearchType::class,$search);
        $form->handleRequest($request);

        $users = $paginator->paginate($this->repository->findAllQuery($search), $request->query->getInt('page',1), 12);
        return $this->render('/admin/user-manager.html.twig', [
            'contact' => $contact ,
            'users' => $users ,
            'form'  => $form->createView(),
        ]);
    }
       /**
     * @Route("/profile_update-{id}", name="profile_update_admin", methods="GET|POST")
     */
    public function profile_admin(Request $request, User $user) {

        $contact = $this->contactRepository->find(1);
        $form = $this->createForm(AccountType::class, $user, array('user' => $this->getUser()));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash(
                'success',
                "This account has been updated successfully.");
            return $this->redirectToRoute('users_manager');
        }

        return $this->render('/security/profile-edit.html.twig', [
            'contact' => $contact ,
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile_delete-{id}", name="profile_delete_admin", methods="DELETE")
     */

    public function delete(User $user, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token')))
        {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success','User has been Deleted sussessfully');
        }
        return $this->redirectToRoute('users_manager');
    }

    /**
     * @Route("/profile_message-{id}", name="profile_message", methods="GET|POST")
     */

    public function message(User $user, PaginatorInterface $paginator, Request $request){
     
        $contact = $this->contactRepository->find(1);
        $message = new Message();
        $form = $this->createForm(MessageType::class,$message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $message->setDestination($user);
            $user->setAnswered(true);
            $message->setAuthor($this->getUser());
            $this->getUser()->setAnswered(false);
            $this->em->persist($message);
            $this->em->flush();

            $this->addFlash(
                'success',
                "Message has been sended successfully.");}

        $messages = $paginator->paginate($this->repositoryMessage->findAllMessageQuery($user), $request->query->getInt('page',1), 3);
        return $this->render('/admin/message.html.twig', [
            'contact' => $contact ,
            'messages' => $messages,
            'user' => $user ,
            'form'  => $form->createView()]);
        }

       /**
     * @Route("/profile_message-{id}", name="message.profile.delete", methods="DELETE")
     */

    public function deleteMessage( Message $message, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$message->getId(), $request->get('_token')))
        {
            $this->em->remove($message);
            $this->em->flush();
            $this->addFlash('success','messsage has been Deleted sussessfully');
        }
        return $this->redirectToRoute('admin.property.index');
    }
        
    
}