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

use CmsModule\Content\Entities\ExtendedPageEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity(repositoryClass="\CmsModule\Content\Repositories\PageRepository")
 * @ORM\Table(name="mailformPage")
 */
class PageEntity extends ExtendedPageEntity
{

	/**
	 * @var MailformEntity
	 * @ORM\OneToOne(targetEntity="MailformEntity", cascade={"all"})
	 */
	protected $mailform;


	public function startup()
	{
		$this->mailform = new MailformEntity();
	}


	/**
	 * @return string
	 */
	public static function getMainRouteName()
	{
		return 'MailformModule\Entities\RouteEntity';
	}


	/**
	 * @return \MailformModule\Entities\MailformEntity
	 */
	public function getMailform()
	{
		return $this->mailform;
	}
}
