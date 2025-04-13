<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 12/04/2025, 12:36
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractUserCrudController.php
 * @date    17/02/2025
 * @time    20:42
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Idm\Bundle\User\Enums\UserRolesEnum;
use function Symfony\Component\Translation\t;

abstract class AbstractUserCrudController extends AbstractCrudController
{
	public function configureFields (string $pageName): iterable
	{
		$t = fn($message) => t($message, [], 'IdmUserBundle');

		yield 'id' => IdField::new('id', $t('crud.common.uuid'))->onlyOnDetail();
		yield 'display_name' => TextField::new('displayName', $t('crud.user.display_name'));
		yield 'email' => EmailField::new('email', $t('crud.common.email'));
		yield 'is_deleted' => BooleanField::new('isDeleted', $t('crud.common.is_deleted'))
			->hideOnForm()->renderAsSwitch(false)->setVirtual(true)
		;
		yield 'deleted_at' => DateTimeField::new('deletedAt', $t('crud.common.deleted_at'))->hideOnIndex();

		yield 'roles' => ChoiceField::new('roles', $t('crud.common.roles'))
			->hideOnIndex()->allowMultipleChoices()
			->setTranslatableChoices(UserRolesEnum::toTranslatableChoices('user_role.'))
		;
		yield 'verified' => BooleanField::new('verified', $t('crud.user.verified'));
		yield 'inactive' => BooleanField::new('inactive', $t('crud.user.inactive'));
		yield 'terms_accepted' => BooleanField::new('termsAccepted', $t('crud.user.terms_accepted'));
		yield 'privacy_accepted' => BooleanField::new('privacyAccepted', $t('crud.user.privacy_accepted'));
		yield 'banned_until' => DateTimeField::new('bannedUntil', $t('crud.user.banned_until'));
		yield 'is_banned' => BooleanField::new('isBanned', $t('crud.common.is_banned'))
			->hideOnForm()->renderAsSwitch(false)->setVirtual(true)
		;
	}

	public function configureCrud (Crud $crud): Crud
	{
		$t = fn($message) => t($message, [], 'IdmUserBundle');

		return parent::configureCrud($crud)
			->setEntityLabelInPlural($t('entity.label.user.plural'))
			->setentityLabelInSingular($t('entity.label.user.singular'))
			->setSearchFields(['email', 'displayName'])
			->setSearchMode(SearchMode::ANY_TERMS)
		;
	}

	public function configureFilters (Filters $filters): Filters
	{
		return $filters
			->add('email')
			->add('displayName')
		;
	}
}
