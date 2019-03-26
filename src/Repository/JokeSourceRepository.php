<?php namespace App\Repository;

use App\Entity\JokeSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JokeSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method JokeSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method JokeSource[]    findAll()
 * @method JokeSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeSourceRepository extends ServiceEntityRepository {
	public function __construct(RegistryInterface $registry) {
		parent::__construct($registry, JokeSource::class);
	}

}
