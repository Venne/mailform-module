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
use MailformModule\Entities\InputEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class MailformfrontFormFactory extends FormFactory
{
	protected function getControlExtensions()
	{
		return array_merge(parent::getControlExtensions(), array(
			new \FormsModule\ControlExtensions\ControlExtension(),
		));
	}


	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$container = $form->addContainer('_inputs');
		$container->setCurrentGroup($form->addGroup());

		$container->addText('_email', 'E-mail');
		$container->addText('_name', 'Name');
		foreach ($form->data->inputs as $input) {
			if ($input->getType() === InputEntity::TYPE_GROUP) {
				$container->setCurrentGroup($form->addGroup($input->getName()));
				continue;
			}

			$control = $container->add($input->getType(), $input->getName(), $input->getLabel());

			if ($input->getType() === InputEntity::TYPE_SELECT || $input->getType() === InputEntity::TYPE_CHECKBOX_LIST) {
				$control->setItems($input->getItems(), false);
			}
		}

		$form->addGroup();
		$form->addSaveButton('Send');
	}


	public function handleSave(Form $form)
	{
	}


	public function handleSuccess(Form $form)
	{
		$values = $form['_inputs']->getValues();

		$message = '';
		foreach ($values as $key => $val) {
			if (substr($key, 0, 1) == '_') {
				continue;
			}
			$message .= "$key: $val\n";
		}

		$mail = new \Nette\Mail\Message();
		$mail->setFrom("{$values['_name']} <{$values['_email']}>");

		foreach ($form->data->emails as $email) {
			$mail->addTo($email);
		}

		$mail->setSubject($form->data->subject);
		$mail->setBody($message);
		$mail->send();
	}
}
