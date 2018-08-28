<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 23/08/2018
 * Time: 10:54
 */
namespace App\Controller;

use App\Entity\Avatar;
use App\Form\ProfileType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, FileUploader $fileUploader)
    {
        $user = $this->getUser();


        $form = $this->createForm(ProfileType::class,$user)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre profil est MàJ!');

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/profile.html.twig', array(
            'form' => $form->createView()
        ));

    }
}
