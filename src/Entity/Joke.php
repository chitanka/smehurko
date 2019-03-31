<?php namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JokeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Joke {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $title;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $subtitle;

	/**
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\JokeSource", inversedBy="jokes")
	 */
	private $source;

	/**
	 * @ORM\ManyToMany(targetEntity="JokeTheme", inversedBy="jokes")
	 * @ORM\JoinTable(name="joke_themes")
	 * @ORM\OrderBy({"name" = "ASC"})
	 */
	private $themes;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;

	/**
	 * @ORM\Column(type="float")
	 */
	private $randomKey;

	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\JokeSubmission", inversedBy="joke", cascade={"persist", "remove"})
	 */
	private $jokeSubmission;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Joke")
	 * @ORM\JoinTable(name="similar_jokes")
	 */
	private $similarJokes;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $nrOfSimilarJokes = 0;

	public function __construct() {
		$this->themes = new ArrayCollection();
		$this->similarJokes = new ArrayCollection();
	}

	public function getId(): int {
		return $this->id;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function setTitle(string $title) {
		$this->title = $title;
	}

	public function getSubtitle(): ?string {
		return $this->subtitle;
	}

	public function setSubtitle(?string $subtitle) {
		$this->subtitle = $subtitle;
	}

	public function getContent(): string {
		return $this->content;
	}

	public function setContent(string $content) {
		$this->content = $content;
	}

	public function getSource(): ?JokeSource {
		return $this->source;
	}

	public function setSource(?JokeSource $source) {
		$this->source = $source;
	}

	/**
	 * @return Collection|JokeTheme[]
	 */
	public function getThemes(): Collection {
		return $this->themes;
	}

	public function addTheme(JokeTheme $theme) {
		if (!$this->themes->contains($theme)) {
			$this->themes[] = $theme;
		}
	}

	public function removeTheme(JokeTheme $theme) {
		if ($this->themes->contains($theme)) {
			$this->themes->removeElement($theme);
		}
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeInterface $createdAt) {
		$this->createdAt = $createdAt;
	}

	public function getUpdatedAt(): ?\DateTimeInterface {
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTimeInterface $updatedAt) {
		$this->updatedAt = $updatedAt;
	}

	public function getJokeSubmission(): ?JokeSubmission {
		return $this->jokeSubmission;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function onCreation() {
		$this->createdAt = new \DateTime();
		$this->randomKey = self::generateRandomKey();
	}

	public static function generateRandomKey() {
		return mt_rand() / mt_getrandmax();
	}

	/**
	 * @return Collection|self[]
	 */
	public function getSimilarJokes(): Collection {
		return $this->similarJokes;
	}

	public function addSimilarJoke(self $similarJoke) {
		if (!$this->similarJokes->contains($similarJoke)) {
			$this->similarJokes[] = $similarJoke;
		}
	}

	public function removeSimilarJoke(self $similarJoke) {
		if ($this->similarJokes->contains($similarJoke)) {
			$this->similarJokes->removeElement($similarJoke);
		}
	}

	public function getNrOfSimilarJokes(): ?int {
		return $this->nrOfSimilarJokes;
	}

	public function setNrOfSimilarJokes(int $nrOfSimilarJokes) {
		$this->nrOfSimilarJokes = $nrOfSimilarJokes;
	}

	public function hasSimilarJokes(): bool {
		return $this->nrOfSimilarJokes > 0;
	}
}
