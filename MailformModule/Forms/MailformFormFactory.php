<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace MailformModule\Forms;

use Venne;
use MailformModule\Entities\InputEntity;
use Venne\Forms\Form;
use DoctrineModule\Forms\FormFactory;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class MailformFormFactory extends FormFactory
{


	protected function getControlExtensions()
	{
		return array_merge(parent::getControlExtensions(), array(
			new \CmsModule\Content\ControlExtension(),
			new \FormsModule\ControlExtensions\ControlExtension(),
		));
	}


	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$form->addGroup('Recipient');
		$form->addTags('emails', 'E-mails')->addRule($form::FILLED, 'Please set e-mail.');
		$form->addText('subject', 'Subject')->addRule($form::FILLED, 'Please set subject.');

		$group = $form->addGroup('Inputs');

		/** @var $items \Nette\Forms\Container */
		$items = $form->addMany('inputs', function (\Nette\Forms\Container $container) use ($group, $form) {
			$container->setCurrentGroup($group);
			$container->addText('label', 'Label');
			$container->addSelect('type', 'Type', InputEntity::getTypes())
				->addCondition($form::IS_IN, array(
					InputEntity::TYPE_CHECKBOX_LIST,
					InputEntity::TYPE_RADIO_LIST,
					InputEntity::TYPE_SELECT)
			)
				->toggle("frm{$form->getUniqueId()}-inputs-{$container->getName()}-items-pair")
				->endCondition()
				->addCondition($form::IS_IN, array(
					InputEntity::TYPE_CHECKBOX,
					InputEntity::TYPE_TEXT, InputEntity::TYPE_TEXTAREA,
					InputEntity::TYPE_CHECKBOX_LIST,
					InputEntity::TYPE_RADIO_LIST,
					InputEntity::TYPE_SELECT)
			)
				->toggle("frm{$form->getUniqueId()}-inputs-{$container->getName()}-required-pair");
			$container->addTags('items', 'Items');
			$container->addCheckbox('required', 'Required');

			$container->addSubmit('remove', 'Remove input')
				->addRemoveOnClick();
		});

		$items->setCurrentGroup($group = $form->addGroup());
		$items->addSubmit('add', 'Add input')
			->setValidationScope(FALSE)
			->addCreateOnClick();

		$form->addSaveButton('Save');
	}
}
