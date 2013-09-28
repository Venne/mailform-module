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

use CmsModule\Content\Entities\ExtendedRouteEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="mailform_route")
 */
class RouteEntity extends ExtendedRouteEntity
{

	/**
	 * @return string
	 */
	protected function getPresenterName()
	{
		return 'Mailform:Mailform:default';
	}


	public static function getPageName()
	{
		return 'MailformModule\Entities\PageEntity';
	}
}
