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
use MailformModule\Components\MailControl;
use Nette\Callback;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class MailformPresenter extends PagePresenter
{

	/** @var Callback */
	protected $mailControlFactory;


	/**
	 * @param \Nette\Callback $mailControlFactory
	 */
	public function __construct(Callback $mailControlFactory)
	{
		parent::__construct();

		$this->mailControlFactory = $mailControlFactory;
	}


	/**
	 * @return MailControl
	 */
	protected function createComponentForm()
	{
		/** @var $control MailControl */
		$control = $this->mailControlFactory->invoke($this->page->mailform);
		$control->onSuccess[] = $this->formSuccess;
		return $control;
	}


	public function formSuccess(MailControl $control)
	{
		$this->flashMessage('Message has been sent', 'success');
		$this->redirect('this');
	}
}
