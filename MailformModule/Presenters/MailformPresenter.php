<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace MailformModule\Presenters;

use Venne;
use CmsModule\Content\Presenters\PagePresenter;
use MailformModule\Forms\MailformfrontFormFactory;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class MailformPresenter extends PagePresenter
{

	/** @var MailformfrontFormFactory */
	protected $formFactory;


	/**
	 * @param \MailformModule\Forms\MailformfrontFormFactory $formFactory
	 */
	public function injectFormFactory(MailformfrontFormFactory $formFactory)
	{
		$this->formFactory = $formFactory;
	}


	public function createComponentForm()
	{
		$form = $this->formFactory->invoke($this->page);
		$form->onSuccess[] = $this->formSuccess;
		return $form;
	}


	public function formSuccess()
	{
		$this->flashMessage('Message has been sent', 'success');
		$this->redirect('this');
	}
}
