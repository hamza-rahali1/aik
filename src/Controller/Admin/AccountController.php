<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Message;
use App\Entity\Property;
use App\Form\AccountType;
use App\Form\MessageType;
use App\Entity\Testimanial;
use App\Form\TestimanialType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Symfony\Component\Form\FormError;
use App\Repository\ContactAIKRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TestimanialRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends Controller
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
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $contact = $this->contactRepository->find(1);
        $error = $authenticationUtils->getLastAuthenticationError();
        $last_username = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig' ,
        [
            'contact' => $contact ,
            'last_username' => $last_username,
            'error' => $error
        ]
    
    );
    }


    /**
     * @Route("/register", name="register")
     */

    public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder){
        $user = new User();
        $contact = $this->contactRepository->find(1);
        $form = $this->createForm(RegistrationType::class, $user, array('user' => $this->getUser()));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                "Your account has been created successfully, Welcome!"
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig',[
            'contact' => $contact ,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile_update", name="profile_update")
     */
    public function profile(Request $request, EntityManagerInterface $em) {
        $user = $this->getUser();
        $contact = $this->contactRepository->find(1);
        $form = $this->createForm(AccountType::class, $user, array('user' => $this->getUser()));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                "Your account has been updated successfully."
            );
        }

        return $this->render('/security/profile-edit.html.twig', [
            'contact' => $contact ,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/password_update", name="password_update")
     */
    public function password(Request $request, EntityManagerInterface $em,  UserPasswordEncoderInterface $encoder) {
        $user = $this->getUser();
        $contact = $this->contactRepository->find(1);
        $passwordUpdate = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
                $form->get('oldPassword')->addError(new FormError("Wrong password! Please enter your current password"));
            }
            else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'success',
                    "Your password has been updated successfully.");
            }
            }

        return $this->render('/security/password.html.twig', [
            'contact' => $contact ,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user_account", name="user_account")
     */
    public function account(){
        $contact = $this->contactRepository->find(1);
        return $this->render('/user-account/account.html.twig', [
            'contact' => $contact ,
        ]);
    }

    /**
     * @Route("/user_favories", name="user_favories")
     */
    public function favories(PaginatorInterface $paginator, Request $request){
        $contact = $this->contactRepository->find(1);
        $favories = $paginator->paginate($this->getUser()->getFavories() , $request->query->getInt('page',1), 12);
        return $this->render('/user-account/favories.html.twig', [
            'contact' => $contact ,
            'favories' => $favories,
        ]);
    }
    
    /**
     * @Route("/user_messages", name="user_messages")
     */
    public function messages(PaginatorInterface $paginator, Request $request){
        $contact = $this->contactRepository->find(1);
        $user = $this->getUser();

        $message = new Message();
        $form = $this->createForm(MessageType::class,$message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
        
            if ($this->repositoryMessage->findLatest($user) == NULL){
                $message->setDestination($this->aikMail);
            }
            else
            {
                $lastMessage = $this->repositoryMessage->findLatest($user)[0];
                $sender = new User();
                $sender = $lastMessage->getAuthor();
                $message->setDestination($sender);
            }
            $message->setAuthor($user);
            $user->setAnswered(false);
            $this->em->persist($message);
            $this->em->flush();

            $this->addFlash(
                'success',
                "Message has been sended successfully.");
            
                return $this->redirectToRoute('user_messages');}

        
        $messages = $paginator->paginate($this->repositoryMessage->findAllMessageQuery($user) , $request->query->getInt('page',1), 3);
        
        return $this->render('/user-account/messages.html.twig', [
            'contact' => $contact ,
            'messages' => $messages,
            'user' => $user ,
            'form'  => $form->createView() 
        ]);
    }
    
    /**
     * @Route("/user_message-{id}", name="message.user.delete", methods="DELETE")
     */

    public function deleteUserMessage( Message $message, Request $request)
    {
        $contact = $this->contactRepository->find(1);
        if($this->isCsrfTokenValid('delete'.$message->getId(), $request->get('_token')))
        {
            $this->em->remove($message);
            $this->em->flush();
            $this->addFlash('success','messsage has been Deleted sussessfully');
        }
        return $this->redirectToRoute('user_messages');
    }

    /**
     * @Route("/user_testimanials", name="user_testimanials")
     */
    public function testimanials(PaginatorInterface $paginator, Request $request){
        $user = $this->getUser();
        $contact = $this->contactRepository->find(1);

        $testimanial = new Testimanial();
        $form = $this->createForm(TestimanialType::class,$testimanial);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $testimanial->setAuthor($user);
            $this->em->persist($testimanial);
            $this->em->flush();

            $this->addFlash(
                'success',
                "Testimanial has been sended successfully.");
            
                return $this->redirectToRoute('user_testimanials');}

        
        $testimanials = $paginator->paginate($this->repositoryTestimanial->findAll() , $request->query->getInt('page',1), 5);
        
        return $this->render('/user-account/testimanial.html.twig', [
            'contact' => $contact ,
            'testimanials' => $testimanials,
            'form'  => $form->createView() 
        ]);
    }

    /**
     * @Route("/user_testimanial-{id}", name="testimanial.user.delete", methods="DELETE")
     */

    public function deleteUserTestimanial( Testimanial $testimanial, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$testimanial->getId(), $request->get('_token')))
        {
            $this->em->remove($testimanial);
            $this->em->flush();
            $this->addFlash('success','Testimanial has been Deleted sussessfully');
        }
        return $this->redirectToRoute('user_testimanials');
    }

    /**
     * @Route("/user_favory-{id}", name="favory.user.add", methods="GET|POST")
     */

    public function userFavory( Property $property, Request $request)
    {
        $contact = $this->contactRepository->find(1);
        $user = $this->getUser();
        $user->addFavory($property);
        $this->em->persist($user);
        $this->em->flush();
        return $this->redirectToRoute('property.show', ['id' => $property->getId(), 'slug' => $property->getSlug()]);
    }

     /**
     * @Route("/user_favory-{id}", name="favory.user.delete", methods="DELETE")
     */

    public function deleteUserFavory( Property $property, Request $request)
    {
        $user = $this->getUser();
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token')))
        {
            $user->removeFavory($property);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success','Property has been Deleted from your Favories list sussessfully');
        }
        return $this->redirectToRoute('user_favories');
    }

}

