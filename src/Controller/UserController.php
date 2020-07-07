<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function register(Request $request, EntityManagerInterface $em)
    {
        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
            }
        return $this->render('security/register.html.twig', [
            'registerForm' => $registerForm->createView()
        ]);
    }
}
