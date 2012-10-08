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
		$items = $form->addMany('inputs', function (\Nette\Forms\Container $container) use ($group) {
			$container->setCurrentGroup($group);
			$container->addText('name', 'Name');
			$container->addSelect('type', 'Type', \MailformModule\Entities\InputEntity::getTypes());
			$container->addText('label', 'Label');
			$container->addCheckbox('required', 'Required');
			$container->addTags('items', 'Items');

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
