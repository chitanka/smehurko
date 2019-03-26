<?php namespace App\Repository;

use App\Entity\JokeLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JokeLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method JokeLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method JokeLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeLabelRepository extends ServiceEntityRepository {
	public function __construct(RegistryInterface $registry) {
		parent::__construct($registry, JokeLabel::class);
	}

    /** @return JokeLabel[] */
	public function findAll() {
		return $this->createQueryBuilder('l')
			->orderBy('l.name', 'ASC')
			->getQuery()->getResult();
	}
}
