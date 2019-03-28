<?php namespace App\Controller;

use App\Entity\Joke;
use App\Entity\JokeTheme;
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
		$themes = $this->getDoctrine()->getRepository(JokeTheme::class)->findAll();
		$sources = $this->getDoctrine()->getRepository(JokeSource::class)->findAll();
		return $this->render('Joke/index.html.twig', [
			'themes' => $themes,
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
	 * @Route("/themes")
	 */
	public function indexThemes() {
		$themes = $this->getDoctrine()->getRepository(JokeTheme::class)->findAll();
		return $this->render('Joke/indexThemes.html.twig', ['themes' => $themes]);
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
	public function listByTheme(Request $request, JokeTheme $theme) {
		$pager = $this->pager($request, $theme->getJokes());
		return $this->render('Joke/listByTheme.html.twig', ['theme' => $theme, 'pager' => $pager]);
	}

}
