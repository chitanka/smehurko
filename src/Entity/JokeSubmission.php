<?php namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
	 * @ORM\ManyToMany(targetEntity="JokeTheme", inversedBy="jokeSubmissions")
	 * @ORM\JoinTable(name="joke_submission_themes")
	 * @ORM\OrderBy({"name" = "ASC"})
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
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="approvedJokeSubmissions")
	 */
	private $approver;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $approvedAt;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rejectedJokeSubmissions")
	 */
	private $rejecter;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $rejectedAt;

	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\Joke", mappedBy="jokeSubmission", cascade={"persist", "remove"})
	 */
	private $joke;

	public static function newByCreator(User $creator) {
		$self = new self();
		$self->creator = $creator;
		return $self;
	}

	public function __construct() {
		$this->themes = new ArrayCollection();
	}

	public function __toString() {
		return $this->getTitleOrDefault();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getTitle(): ?string {
		return $this->title;
	}

	public function getTitleOrDefault(): ?string {
		return $this->title ?: mb_substr($this->content, 0, 60).'…';
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

	public function getApprovedAt(): ?\DateTimeInterface {
		return $this->approvedAt;
	}

	public function getRejectedAt(): ?\DateTimeInterface {
		return $this->rejectedAt;
	}

	public function getJoke(): ?Joke {
		return $this->joke;
	}

	public function approve(User $approver, Joke $joke) {
		$this->approver = $approver;
		$this->approvedAt = new \DateTime();
		$this->joke = $joke;
		$this->rejecter = null;
		$this->rejectedAt = null;
	}

	public function reject(User $rejecter) {
		$this->rejecter = $rejecter;
		$this->rejectedAt = new \DateTime();
		$this->approver = null;
		$this->approvedAt = null;
	}

	public function isApproved(): bool {
		return $this->approvedAt !== null;
	}

	public function isRejected(): bool {
		return $this->rejectedAt !== null;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function onCreation() {
		$this->createdAt = new \DateTime();
	}

}
