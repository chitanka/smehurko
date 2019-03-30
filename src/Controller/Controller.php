<?php namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method User getUser()
 */
abstract class Controller extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController {

	const PARAM_PAGER_PAGE = 'page';
	const ITEMS_PER_PAGE = 12;

	protected function pager(Request $request, $query, $maxPerPage = null) {
		return $this->createPager($this->createPagerAdapter($query), $request, $maxPerPage);
	}

	private function createPagerAdapter($query) {
		if ($query instanceof Collection) {
			return new DoctrineCollectionAdapter($query);
		}
		return new DoctrineORMAdapter($query);
	}

	private function createPager($adapter, Request $request, $maxPerPage) {
		$pager = new Pagerfanta($adapter);
		$pager->setMaxPerPage($maxPerPage ?: self::ITEMS_PER_PAGE);
		$pager->setCurrentPage($request->query->get(self::PARAM_PAGER_PAGE, 1));
		return $pager;
	}
}
