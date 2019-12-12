<?php namespace App\Repository;

use App\Entity\JokeSubmission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method JokeSubmission|null find($id, $lockMode = null, $lockVersion = null)
 * @method JokeSubmission|null findOneBy(array $criteria, array $orderBy = null)
 * @method JokeSubmission[]    findAll()
 * @method JokeSubmission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeSubmissionRepository extends ServiceEntityRepository {
	public function __construct(\Doctrine\Common\Persistence\ManagerRegistry $registry) {
		parent::__construct($registry, JokeSubmission::class);
	}

}
