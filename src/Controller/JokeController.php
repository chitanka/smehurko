<?php namespace App\Controller;

use App\Entity\Joke;
use App\Entity\JokeSubmission;
use App\Entity\JokeTheme;
use App\Entity\JokeSource;
use App\Form\JokeSubmissionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jokes")
 */
class JokeController extends Controller {

	const PARAM_SEARCH_QUERY = 'q';
	const MIN_SEARCH_QUERY_LENGTH = 3;

	/**
	 * @Route("/")
	 */
	public function index(Request $request) {
		if (strlen($searchQuery = $request->query->get(self::PARAM_SEARCH_QUERY, '')) >= self::MIN_SEARCH_QUERY_LENGTH) {
			$pager = $this->pager($request, $this->getDoctrine()->getRepository(Joke::class)->findByKeyword($searchQuery));
			return $this->render('Joke/list.html.twig', [
				'pager' => $pager,
				'searchQuery' => $searchQuery,
			]);
		}
		$themes = $this->getDoctrine()->getRepository(JokeTheme::class)->findAll();
		$sources = $this->getDoctrine()->getRepository(JokeSource::class)->findAll();
		return $this->render('Joke/index.html.twig', [
			'themes' => $themes,
			'sources' => $sources,
		]);
	}

	/**
	 * @Route("/random.{_format}")
	 */
	public function random(string $_format = 'html') {
		$jokes = $this->getDoctrine()->getRepository(Joke::class)->findRandom();
		return $this->renderRandomJokes($jokes, $_format);
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
	 * Show only submissions for the current user
	 * @Route("/submissions")
	 */
	public function listSubmissions(Request $request) {
		$pager = $this->pager($request, $this->getUser()->getJokeSubmissions());
		return $this->render('Joke/listSubmissions.html.twig', ['pager' => $pager]);
	}

	/**
	 * Show submissions which are pending for approval
	 * @Route("/pending-submissions")
	 */
	public function listPendingSubmissions(Request $request) {
		$pager = $this->pager($request, $this->getDoctrine()->getRepository(JokeSubmission::class)->findPending());
		return $this->render('Joke/listSubmissions.html.twig', ['pager' => $pager]);
	}

	/**
	 * @Route("/{slug}/random.{_format}")
	 */
	public function randomByTheme(JokeTheme $theme, string $_format = 'html') {
		$jokes = $this->getDoctrine()->getRepository(Joke::class)->findRandomByTheme($theme);
		return $this->renderRandomJokes($jokes, $_format);
	}

	/**
	 * @Route("/{slug}")
	 */
	public function listByTheme(Request $request, JokeTheme $theme) {
		$pager = $this->pager($request, $theme->getJokes());
		return $this->render('Joke/listByTheme.html.twig', ['theme' => $theme, 'pager' => $pager]);
	}

	/**
	 * @Route("/submissions/new")
	 */
	public function newSubmission(Request $request) {
		$submission = JokeSubmission::newByCreator($this->getUser());
		$form = $this->createForm(JokeSubmissionType::class, $submission);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($form->getData());
			$entityManager->flush();
			return $this->redirectToRoute('app_joke_listsubmissions');
		}
		return $this->render('Joke/newSubmission.html.twig', [
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/submissions/{id<\d+>}/approve", methods={"POST"})
	 */
	public function approveSubmission(JokeSubmission $jokeSubmission) {
		$joke = Joke::newFromSubmission($jokeSubmission);
		$jokeSubmission->approve($this->getUser(), $joke);
		$this->storeEntities($joke, $jokeSubmission);
		$this->addFlash('success', "Одобрена: $jokeSubmission");
		return $this->redirectToRoute('app_joke_listpendingsubmissions');
	}

	/**
	 * @Route("/submissions/{id<\d+>}/reject", methods={"POST"})
	 */
	public function rejectSubmission(JokeSubmission $jokeSubmission) {
		$jokeSubmission->reject($this->getUser());
		$this->storeEntities($jokeSubmission);
		$this->addFlash('success', "Отхвърлена: $jokeSubmission");
		return $this->redirectToRoute('app_joke_listpendingsubmissions');
	}

	private function renderRandomJokes($jokes, $format) {
		if (in_array($format, ['txt', 'md']) && count($jokes) > 0) {
			return $this->render('Joke/show.txt.twig', ['joke' => $jokes[0]]);
		}
		return $this->render('Main/index.html.twig', ['jokes' => $jokes]);
	}
}
