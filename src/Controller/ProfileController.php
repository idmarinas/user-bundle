<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/12/2024, 16:57
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ProfileController.php
 * @date    26/12/2024
 * @time    21:10
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Form\ChangePasswordFormType;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Model\Repository\AbstractUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\Translation\t;

#[Route(path: '/profile', name: 'profile_')]
final class ProfileController extends AbstractController
{
	#[Route(name: 'index', methods: ['GET'])]
	public function index (): Response
	{
		return $this->render('@IdmUser/profile/index.html.twig');
	}

	#[Route(path: '/change/password', name: 'change_password', methods: ['GET', 'POST'])]
	public function changePassword (
		Request                     $request,
		EntityManagerInterface      $entityManager,
		UserPasswordHasherInterface $passwordHasher
	): Response {
		/** @var AbstractUser $user */
		$user = $this->getUser();
		$form = $this->createForm(ChangePasswordFormType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			/* @var AbstractUserRepository $repository */
			$repository = $entityManager->getRepository(AbstractUser::class);
			$repository->upgradePassword($user, $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

			return $this->redirectToRoute('idm_user_profile_index');
		}

		return $this->render('@IdmUser/profile/change_password.html.twig', [
			'form' => $form,
		]);
	}

	//    #[Route(path: '/accept/terms_and_privacy', name: 'accept_terms_privacy')]
	//    public function acceptTermsPrivacy(): Response
	//    {
	//        $this->seoPage->setTitle($this->translator->trans('title.terms_and_privacy', [], self::TRANSLATION_DOMAIN));
	//
	//        return $this->render('pages/user/profile/accept_terms_privacy.html.twig', [
	//            'translation_domain' => self::TRANSLATION_DOMAIN
	//        ]);
	//    }

	#[Route(path: '/delete', name: 'delete_user', methods: ['GET'])]
	public function deleteUser (): Response
	{
		return $this->render('@IdmUser/profile/delete_user.html.twig');
	}

	#[Route(path: '/delete/confirm', name: 'delete_user_confirm', methods: ['POST'])]
	public function deleteUserAccount (Request $request, EntityManagerInterface $entityManager): Response
	{
		$token = $request->request->get('token');

		if ($this->isCsrfTokenValid('delete-user', $token)) {
			$entityManager->remove($this->getUser());
			$entityManager->flush();

			return $this->redirectToRoute('_logout_main');
		}

		$this->addFlash('error', t('flash.error.delete_user.csrf', [], 'IdmUserBundle'));

		return $this->redirectToRoute('idm_user_profile_index');
	}
}
