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
use CmsModule\Content\Entities\PageEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @Entity(repositoryClass="\CmsModule\Content\Repositories\PageRepository")
 * @Table(name="mailformPage")
 * @DiscriminatorEntry(name="mailformPage")
 */
class MailformEntity extends PageEntity
{

	/**
	 * @var ArrayCollection|InputEntity[]
	 * @OneToMany(targetEntity="InputEntity", mappedBy="mailform", cascade={"persist"})
	 */
	protected $inputs;

	/**
	 * @var string
	 * @Column(type="string")
	 */
	protected $emails;

	/**
	 * @var string
	 * @Column(type="string")
	 */
	protected $subject;


	public function __construct()
	{
		parent::__construct();

		$this->mainRoute->type = 'Mailform:Default:default';
		$this->emails = '';
		$this->subject = '';

		$this->inputs[] = new InputEntity($this, 'text', InputEntity::TYPE_TEXTAREA, 'Text');
	}


	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $inputs
	 */
	public function setInputs($inputs)
	{
		$this->inputs = $inputs;
	}


	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getInputs()
	{
		return $this->inputs;
	}


	/**
	 * @param string $emails
	 */
	public function setEmails($emails)
	{
		$this->emails = implode(';', $emails);
	}


	/**
	 * @return string
	 */
	public function getEmails()
	{
		return explode(';', $this->emails);
	}


	/**
	 * @param string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}


	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}
}
