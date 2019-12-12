<?php namespace App\Repository;

use App\Entity\JokeTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method JokeTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method JokeTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method JokeTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeThemeRepository extends ServiceEntityRepository {
	public function __construct(\Doctrine\Common\Persistence\ManagerRegistry $registry) {
		parent::__construct($registry, JokeTheme::class);
	}

    /** @return JokeTheme[] */
	public function findAll() {
		return $this->createQueryBuilder('e')
			->where('e.nrOfJokes > 0')
			->orderBy('e.name', 'ASC')
			->getQuery()->getResult();
	}
}
