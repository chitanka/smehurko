<?php namespace App\Listener;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class KernelListener implements EventSubscriberInterface {

	public static function getSubscribedEvents() {
		return [
			KernelEvents::REQUEST => 'onKernelRequest',
		];
	}

	private $userRepo;
	private $tokenStorage;
	private $singleLoginProvider;
	private $twig;

	public function __construct(UserRepository $userRepo, TokenStorageInterface $tokenStorage, $singleLoginProvider, \Twig_Environment $twig) {
		$this->userRepo = $userRepo;
		$this->tokenStorage = $tokenStorage;
		$this->singleLoginProvider = $singleLoginProvider;
		$this->twig = $twig;
	}

	/**
	 * @param GetResponseEvent $event
	 */
	public function onKernelRequest(GetResponseEvent $event) {
		if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
			return;
		}
		$this->initTokenStorage();
	}

	private function initTokenStorage() {
		$user = $this->initUser();
		$token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, null, 'User', $user->getRoles());
		$this->tokenStorage->setToken($token);
	}

	private function initUser() {
		if (!$this->singleLoginProvider) {
			return User::createAnonymousUser();
		}
		$chitankaUser = (require $this->singleLoginProvider)();
		if ($chitankaUser['username']) {
			return $this->userRepo->findByUsername($chitankaUser['username']) ?: $this->userRepo->createUser($chitankaUser['username'], $chitankaUser['email']);
		}
		return User::createAnonymousUser();
	}

}
