<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JokeSubmissionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class JokeSubmission {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $title;

	/**
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $themes;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $source;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jokeSubmissions")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $creator;

	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Joke", inversedBy="jokeSubmission", cascade={"persist", "remove"})
	 */
	private $joke;

	public static function newByCreator(User $creator) {
		$self = new self();
		$self->creator = $creator;
		return $self;
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getTitle(): ?string {
		return $this->title ?: ($this->content ? mb_substr($this->content, 0, 60).'…' : null);
	}

	public function setTitle(string $title) {
		$this->title = $title;
	}

	public function getContent(): ?string {
		return $this->content;
	}

	public function setContent(string $content) {
		$this->content = $content;
	}

	public function getThemes(): ?string {
		return $this->themes;
	}

	public function setThemes(?string $themes) {
		$this->themes = $themes;
	}

	public function getSource(): ?string {
		return $this->source;
	}

	public function setSource(?string $source) {
		$this->source = $source;
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeInterface $createdAt) {
		$this->createdAt = $createdAt;
	}

	public function getCreator(): ?User {
		return $this->creator;
	}

	public function setCreator(?User $creator) {
		$this->creator = $creator;
	}

	public function getJoke(): ?Joke {
		return $this->joke;
	}

	public function setJoke(?Joke $joke) {
		$this->joke = $joke;
	}

	public function isApproved() {
		return $this->joke !== null;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function onCreation() {
		$this->createdAt = new \DateTime();
	}

}
