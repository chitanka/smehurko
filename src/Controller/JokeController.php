<?php namespace App\Controller;

use App\Entity\Joke;
use App\Entity\JokeLabel;
use App\Entity\JokeSource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jokes")
 */
class JokeController extends Controller {

	/**
	 * @Route("/")
	 */
	public function index() {
		$labels = $this->getDoctrine()->getRepository(JokeLabel::class)->findAll();
		$sources = $this->getDoctrine()->getRepository(JokeSource::class)->findAll();
		return $this->render('Joke/index.html.twig', [
			'labels' => $labels,
			'sources' => $sources,
		]);
	}

	/**
	 * @Route("/random")
	 */
	public function random() {
		$jokes = $this->getDoctrine()->getRepository(Joke::class)->findRandom();
		return $this->render('Main/index.html.twig', ['jokes' => $jokes]);
	}

	/**
	 * @Route("/{id<\d+>}")
	 */
	public function show(Joke $joke) {
		return $this->render('Joke/show.html.twig', ['joke' => $joke]);
	}

	/**
	 * @Route("/labels")
	 */
	public function indexLabels() {
		$labels = $this->getDoctrine()->getRepository(JokeLabel::class)->findAll();
		return $this->render('Joke/indexLabels.html.twig', ['labels' => $labels]);
	}

	/**
	 * @Route("/sources")
	 */
	public function indexSources() {
		$sources = $this->getDoctrine()->getRepository(JokeSource::class)->findAll();
		return $this->render('Joke/indexSources.html.twig', ['sources' => $sources]);
	}

	/**
	 * @Route("/sources/{slug}")
	 */
	public function listBySource(Request $request, JokeSource $source) {
		$pager = $this->pager($request, $source->getJokes());
		return $this->render('Joke/listBySource.html.twig', ['source' => $source, 'pager' => $pager]);
	}

	/**
	 * @Route("/{slug}")
	 */
	public function listByLabel(Request $request, JokeLabel $label) {
		$pager = $this->pager($request, $label->getJokes());
		return $this->render('Joke/listByLabel.html.twig', ['label' => $label, 'pager' => $pager]);
	}

}
