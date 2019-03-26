<?php namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JokeLabelRepository")
 */
class JokeLabel {
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
	 * @ORM\ManyToMany(targetEntity="App\Entity\Joke", mappedBy="labels")
	 */
	private $jokes;

	public function __construct() {
		$this->jokes = new ArrayCollection();
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

}
