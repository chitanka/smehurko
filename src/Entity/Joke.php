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
	 * @ORM\ManyToMany(targetEntity="App\Entity\JokeLabel", inversedBy="jokes")
	 */
	private $labels;

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

	public function __construct() {
		$this->labels = new ArrayCollection();
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
	 * @return Collection|JokeLabel[]
	 */
	public function getLabels(): Collection {
		return $this->labels;
	}

	public function addLabel(JokeLabel $label) {
		if (!$this->labels->contains($label)) {
			$this->labels[] = $label;
		}
	}

	public function removeLabel(JokeLabel $label) {
		if ($this->labels->contains($label)) {
			$this->labels->removeElement($label);
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
}
