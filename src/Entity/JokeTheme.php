<?php namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JokeThemeRepository")
 */
class JokeTheme {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $slug;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Joke", mappedBy="themes")
	 */
	private $jokes;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $nrOfJokes;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\JokeSubmission", mappedBy="themes")
	 */
	private $jokeSubmissions;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $nrOfJokeSubmissions;

	public function __construct() {
		$this->jokes = new ArrayCollection();
	}

	public function __toString() {
		return $this->name;
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(string $name) {
		$this->name = $name;
	}

	public function getSlug(): ?string {
		return $this->slug;
	}

	public function setSlug(string $slug) {
		$this->slug = $slug;
	}

	/**
	 * @return Collection|Joke[]
	 */
	public function getJokes(): Collection {
		return $this->jokes;
	}

	public function getNrOfJokes(): ?int {
		return $this->nrOfJokes;
	}

	public function setNrOfJokes(int $nrOfJokes) {
		$this->nrOfJokes = $nrOfJokes;
	}

	/**
	 * @return Collection|JokeSubmission[]
	 */
	public function getJokeSubmissions(): Collection {
		return $this->jokeSubmissions;
	}

	public function getNrOfJokeSubmissions(): ?int {
		return $this->nrOfJokeSubmissions;
	}

	public function setNrOfJokeSubmissions(int $nrOfJokeSubmissions) {
		$this->nrOfJokeSubmissions = $nrOfJokeSubmissions;
	}

}
