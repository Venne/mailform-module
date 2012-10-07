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
class MailformfrontFormFactory extends FormFactory
{


	/**
	 * @param Form $form
	 */
	public function configure(Form $form)
	{
		$container = $form->addContainer('_inputs');

		$container->addText('_email', 'E-mail');
		$container->addText('_name', 'Name');
		foreach ($form->data->inputs as $input) {
			$container->add($input->getType(), $input->getName(), $input->getLabel());
		}

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
