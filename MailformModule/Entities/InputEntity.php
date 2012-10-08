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
use DoctrineModule\Entities\NamedEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @Table(name="mailformInput")
 */
class InputEntity extends NamedEntity
{

	const TYPE_TEXT = 'text';

	const TYPE_TEXTAREA = 'textarea';

	const TYPE_SELECT = 'select';

	const TYPE_CHECKBOX = 'checkbox';

	const TYPE_CHECKBOX_LIST = 'checkboxList';

	const TYPE_RADIO_LIST = 'radioList';

	const TYPE_GROUP = 'group';

	/** @var array */
	protected static $types = array(
		self::TYPE_TEXT => 'text',
		self::TYPE_TEXTAREA => 'textarea',
		self::TYPE_SELECT => 'select',
		self::TYPE_CHECKBOX => 'checkbox',
		self::TYPE_CHECKBOX_LIST => 'checkbox list',
		self::TYPE_RADIO_LIST => 'radio list',
		self::TYPE_GROUP => 'group',
	);

	/**
	 * @var string
	 * @Column(type="string")
	 */
	protected $label;

	/**
	 * @var string
	 * @Column(type="string")
	 */
	protected $type;

	/**
	 * @var string
	 * @Column(type="string")
	 */
	protected $items;


	/**
	 * @var boolean
	 * @Column(type="boolean")
	 */
	protected $required;


	/**
	 * @var MailformEntity
	 * @ManyToOne(targetEntity="MailformEntity", inversedBy="inputs")
	 * @JoinColumn(onDelete="CASCADE")
	 */
	protected $mailform;


	/**
	 * @param MailformEntity $mailform
	 * @param null $type
	 * @param null $label
	 */
	public function __construct(MailformEntity $mailform = NULL, $name = NULL, $type = NULL, $label = NULL)
	{
		$this->mailform = $mailform;
		$this->name = $name;
		$this->type = $type ? : self::TYPE_TEXT;
		$this->label = $label;
		$this->items = '';
		$this->required = false;
	}


	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}


	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}


	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$type = $type ? : self::TYPE_TEXT;

		if (!isset(self::$types[$type])) {
			throw new \Nette\InvalidArgumentException("Type '{$type}' does not exist.");
		}

		$this->type = $type;
	}


	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * @param string $items
	 */
	public function setItems($items)
	{
		$this->items = implode(';', $items);
	}


	/**
	 * @return string
	 */
	public function getItems()
	{
		return explode(';', $this->items);
	}


	/**
	 * @param boolean $required
	 */
	public function setRequired($required)
	{
		$this->required = $required;
	}


	/**
	 * @return boolean
	 */
	public function getRequired()
	{
		return $this->required;
	}


	/**
	 * @param \MailformModule\Entities\MailformEntity $mailform
	 */
	public function setMailform($mailform)
	{
		$this->mailform = $mailform;
	}


	/**
	 * @return \MailformModule\Entities\MailformEntity
	 */
	public function getMailform()
	{
		return $this->mailform;
	}


	/**
	 * @return array
	 */
	public static function getTypes()
	{
		return self::$types;
	}
}
