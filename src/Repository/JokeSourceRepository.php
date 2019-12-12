<?php namespace App\Repository;

use App\Entity\JokeSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method JokeSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method JokeSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method JokeSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeSourceRepository extends ServiceEntityRepository {
	public function __construct(\Doctrine\Common\Persistence\ManagerRegistry $registry) {
		parent::__construct($registry, JokeSource::class);
	}

	/** @return JokeSource[] */
	public function findAll() {
		return $this->createQueryBuilder('e')
			->orderBy('e.title', 'ASC')
			->getQuery()->getResult();
	}
}
