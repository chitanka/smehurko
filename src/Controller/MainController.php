<?php namespace App\Controller;

use App\Entity\Joke;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller {

	/**
	 * @Route("/", name="home")
	 */
	public function index(Request $request) {
		$pager = $this->pager($request, $this->getDoctrine()->getRepository(Joke::class)->findRecent());
		return $this->render('Main/index.html.twig', ['pager' => $pager]);
	}

}
