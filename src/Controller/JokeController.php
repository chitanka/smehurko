<?php namespace App\Controller;

use App\Entity\Joke;
use App\Entity\JokeLabel;
use App\Entity\JokeSource;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jokes")
 */
class JokeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController {

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
	public function listBySource(JokeSource $source) {
		$jokes = $source->getJokes();
		return $this->render('Joke/listBySource.html.twig', ['source' => $source, 'jokes' => $jokes]);
	}

	/**
	 * @Route("/{slug}")
	 */
	public function listByLabel(JokeLabel $label) {
		$jokes = $label->getJokes();
		return $this->render('Joke/listByLabel.html.twig', ['label' => $label, 'jokes' => $jokes]);
	}

}
