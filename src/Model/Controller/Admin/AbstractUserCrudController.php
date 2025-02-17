<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/02/2025, 20:53
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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Idm\Bundle\User\Enums\UserRolesEnum;
use function Symfony\Component\Translation\t;

abstract class AbstractUserCrudController extends AbstractCrudController
{
	public function configureFields (string $pageName): iterable
	{
		$t = fn($message) => t($message, [], 'IdmUserBundle');

		// Tab Info
		yield FormField::addTab($t('crud.form.tab.info'), 'fa fa-info');
		yield FormField::addColumn(8);
		yield IdField::new('uuid', $t('crud.common.uuid'))->onlyOnDetail();
		yield TextField::new('displayName', $t('crud.user.display_name'));
		yield EmailField::new('email', $t('crud.common.email'))
			->setPermission('ROLE_SUPER_ADMIN') // Only a superuser can change this
		;

		yield FormField::addColumn(4);
		yield BooleanField::new('isDeleted', $t('crud.common.is_deleted'))
			->hideOnForm()
			->renderAsSwitch(false)
			->setVirtual(true)
		;
		yield DateTimeField::new('deletedAt', $t('crud.common.deleted_at'))
			->hideOnIndex()
			->setPermission('ROLE_SUPER_ADMIN') // Only a superuser can change this
		;

		// Tab Roles
		yield FormField::addTab($t('crud.form.tab.roles'), 'fa-regular fa-id-badge')
			->setPermission('ROLE_SUPER_ADMIN')
		;
		yield ChoiceField::new('roles', $t('crud.common.roles'))
			->hideOnIndex()
			->setTranslatableChoices(UserRolesEnum::toTranslatableChoices())
			->allowMultipleChoices()
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
