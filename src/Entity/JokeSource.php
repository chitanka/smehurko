<?php namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JokeSourceRepository")
 */
class JokeSource {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $url;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Joke", mappedBy="source")
	 */
	private $jokes;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $author;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $title;

	public function __construct() {
		$this->jokes = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getUrl(): ?string {
		return $this->url;
	}

	public function setUrl(?string $url) {
		$this->url = $url;
	}

	/**
	 * @return Collection|Joke[]
	 */
	public function getJokes(): Collection {
		return $this->jokes;
	}

	public function getAuthor(): ?string {
		return $this->author;
	}

	public function setAuthor(?string $author) {
		$this->author = $author;
	}

	public function getTitle(): ?string {
		return $this->title;
	}

	public function setTitle(string $title) {
		$this->title = $title;
	}

}
