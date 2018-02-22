<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    /**
     * @Route("/admin", name="admin")
     * @Template("default/index.html.twig")
     */
    public function admin()
    {
        $texto = "Esse usuário não é admin.";

        if($this->isGranted('ROLE_ADMIN')) {
            $texto = "Esse usuário é um Administrador!";
        }

        return [
            'texto' => $texto
        ];
    }

    /**
     * @Route("/admin/dashboard", name="dashboard")
     * @Template("default/dashboard.html.twig")
     */
    public function dashboard()
    {
        return [];
    }

    /**
     * @Route("/admin/relatorios", name="relatorios")
     * @Template("default/relatorios.html.twig")
     */
    public function relatorios()
    {
        return [];
    }

    /**
     * @Route("/admin/login", name="login")
     * @Template("default/login.html.twig")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return array
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return [
            'error' => $error,
            'last_username' => $lastUsername
        ];
    }

    /**
     * @param Request $request
     *
     * @Route("/insert")
     * @return Response
     */
    public function insert(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername("gilson");
        $user->setEmail("gilson@email.com");
        $user->setRoles("ROLE_USER");

        $encoder = $this->get('security.password_encoder');
        $pass = $encoder->encodePassword($user, "abc");
        $user->setPassword($pass);
        $em->persist($user);


        $user = new User();
        $user->setUsername("admin");
        $user->setEmail("admin@email.com");
        $user->setRoles("ROLE_ADMIN");

        $encoder = $this->get('security.password_encoder');
        $pass = $encoder->encodePassword($user, "qwe");
        $user->setPassword($pass);
        $em->persist($user);

        $em->flush();

        return new Response("<h1>Inserido com sucesso!</h1>");

    }
}
