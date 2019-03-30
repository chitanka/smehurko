<?php namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface {

	const ROLE_PREFIX = 'ROLE_';

	const ROLE_DEFAULT = 'ROLE_USER';
	const ROLE_EDITOR = 'ROLE_EDITOR';
	const ROLE_ADMIN = 'ROLE_ADMIN';

	const ROLES = [
		self::ROLE_EDITOR,
		self::ROLE_ADMIN,
	];

	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=100, unique=true)
	 */
	private $username;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $email;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $lastLogin;

	/**
	 * @var array
	 * @ORM\Column(type="array")
	 */
	private $roles;

	/**
	 * @var array
	 * @ORM\Column(type="object", nullable=true)
	 */
	private $preferences;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\JokeSubmission", mappedBy="creator")
	 * @ORM\OrderBy({"createdAt" = "DESC"})
	 */
	private $jokeSubmissions;

	public static function createAnonymousUser() {
		return new static(null, null);
	}

	public static function normalizeRoleName($roleInput) {
		$role = strtoupper($roleInput);
		if (strpos($role, self::ROLE_PREFIX) === false) {
			$role = self::ROLE_PREFIX.$role;
		}
		return $role;
	}

	public function __construct($username, $email, array $roles = []) {
		$this->username = $username;
		$this->email = $email;
		$this->roles = $roles;
		$this->setLastLogin();
		$this->jokeSubmissions = new ArrayCollection();
	}

	public function __toString() {
		return (string) $this->getUsername();
	}

	public function isAnonymous() {
		return $this->username === null;
	}

	public function isRegistered() {
		return !$this->isAnonymous();
	}

	public function getId(): int {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getName() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastLogin() {
		return $this->lastLogin;
	}

	/**
	 * @param \DateTime $time
	 */
	public function setLastLogin(\DateTime $time = null) {
		$this->lastLogin = $time ?: new \DateTime();
	}

	/**
	 * @return array
	 */
	public function getRoles() {
		return array_merge([self::ROLE_DEFAULT], $this->roles);
	}

	public function getNonDefaultRoles() {
		return $this->roles;
	}

	/**
	 * @param array $roles
	 */
	public function setRoles($roles) {
		$this->roles = $roles;
	}

	public function addRole($role) {
		if (!in_array($role, $this->roles)) {
			$this->roles[] = $role;
		}
	}

	public function removeRole($role) {
		$this->roles = array_diff($this->roles, [$role]);
	}

	public function is($role) {
		return in_array(self::normalizeRoleName($role), $this->getRoles());
	}

	/**
	 * @return array
	 */
	public function getPreferences() {
		return $this->preferences;
	}

	public function getPreference($name, $default = null) {
		if (isset($this->preferences[$name])) {
			return $this->preferences[$name];
		}
		return $default;
	}

	/**
	 * @param array $preferences
	 */
	public function setPreferences($preferences) {
		$this->preferences = $preferences;
	}

	public function setPreference($name, $value) {
		$this->preferences[$name] = $value;
	}

	public function getPassword() {
		return null;
	}

	public function getSalt() {
		return null;
	}

	public function eraseCredentials() {}

	public function toArray() {
		return [
			'username' => $this->getUsername(),
		];
	}

	/**
	 * @return Collection|JokeSubmission[]
	 */
	public function getJokeSubmissions(): Collection {
		return $this->jokeSubmissions;
	}

}
