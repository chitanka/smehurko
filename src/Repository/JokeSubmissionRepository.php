<?php namespace App\Repository;

use App\Entity\JokeSubmission;
use App\Entity\User;
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

	public function findPending() {
		return $this->createQueryBuilder('j')
			->where('j.approvedAt IS NULL AND j.rejectedAt IS NULL')
			->getQuery();
	}

	public function findApproved() {
		return $this->createQueryBuilder('j')
			->where('j.approvedAt IS NOT NULL')
			->getQuery();
	}

	public function findRejected() {
		return $this->createQueryBuilder('j')
			->where('j.rejectedAt IS NOT NULL')
			->getQuery();
	}

	public function findApprovedBy(User $approver) {
		return $this->createQueryBuilder('j')
			->where('j.approver = :approver')->setParameter('approver', $approver)
			->getQuery();
	}

	public function findRejectedBy(User $approver) {
		return $this->createQueryBuilder('j')
			->where('j.rejecter = :approver')->setParameter('approver', $approver)
			->getQuery();
	}

}
