<?php namespace App\Repository;

use App\Entity\Joke;
use App\Entity\JokeLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Joke|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joke|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joke[]    findAll()
 * @method Joke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeRepository extends ServiceEntityRepository {
	public function __construct(RegistryInterface $registry) {
		parent::__construct($registry, Joke::class);
	}

	/**
	* @return Joke[]
	*/
	public function findRecent($maxResults = null) {
		return $this->createQueryBuilder('j')
			->orderBy('j.id', 'DESC')
			->setMaxResults($maxResults ?? 10)
			->getQuery()->getResult();
	}

	/**
	 * @return Joke[]
	 */
	public function findRandom($maxResults = null) {
		return $this->createQueryBuilder('j')
			->where('j.randomKey < ?1')->setParameter(1, Joke::generateRandomKey())
			->orderBy('j.randomKey', 'DESC')
			->setMaxResults($maxResults ?? 1)
			->getQuery()->getResult();
	}

}
