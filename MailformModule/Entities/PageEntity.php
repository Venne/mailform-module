<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace MailformModule\Entities;

use Venne;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @Entity(repositoryClass="\CmsModule\Content\Repositories\PageRepository")
 * @Table(name="mailformPage")
 * @DiscriminatorEntry(name="mailformPage")
 */
class PageEntity extends \CmsModule\Content\Entities\PageEntity
{

	/**
	 * @var MailformEntity
	 * @OneToOne(targetEntity="MailformEntity", cascade={"all"})
	 */
	protected $mailform;


	public function __construct()
	{
		parent::__construct();

		$this->mainRoute->type = 'Mailform:Default:default';
		$this->mailform = new MailformEntity();
	}


	/**
	 * @return \MailformModule\Entities\MailformEntity
	 */
	public function getMailform()
	{
		return $this->mailform;
	}
}
