<?php namespace App\Controller;

use App\Entity\Joke;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController {

	/**
	 * @Route("/", name="home")
	 */
	public function index() {
		$jokes = $this->getDoctrine()->getRepository(Joke::class)->findRecent();
		return $this->render('Main/index.html.twig', ['jokes' => $jokes]);
	}

}
