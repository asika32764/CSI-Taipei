<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Csi\Webometrics;

use Csi\Engine\AbstractEngine;

/**
 * The AbstractWebometrics class.
 * 
 * @since  {DEPLOY_VERSION}
 */
abstract class AbstractWebometrics extends \JModelDatabase
{
	/**
	 * Property engine.
	 *
	 * @var AbstractEngine
	 */
	protected $engine;

	/**
	 * Property keywordTmpl.
	 *
	 * @var  string
	 */
	protected $keywordTmpl = 'site:%s';

	/**
	 * Class init.
	 *
	 * @param AbstractEngine $engine
	 *
	 * @throws \InvalidArgumentException
	 */
	public function __construct(AbstractEngine $engine)
	{
		if (!($engine instanceof AbstractEngine))
		{
			throw new \InvalidArgumentException('Not valid engine instance');
		}

		$this->engine = $engine;
	}

	/**
	 * getInstance
	 *
	 * @param string         $name
	 * @param AbstractEngine $engine
	 *
	 * @return  AbstractWebometrics
	 */
	public static function getInstance($name, AbstractEngine $engine)
	{
		$class = sprintf('Csi\\Webometrics\\%sWebometrics', ucfirst($name));

		return new $class($engine);
	}

	/**
	 * Get Webometrics
	 *
	 * @param string $url
	 *
	 * @return  integer
	 */
	public function getWebometrics($url)
	{
		$this->engine->getState()->set('keyword', sprintf($this->keywordTmpl, $url));

		$page = $this->engine->getPage(1);

		return (int) $this->countWebometrics($page);
	}

	/**
	 * Count Webometrics
	 *
	 * @param string $html
	 *
	 * @return  mixed
	 */
	abstract protected function countWebometrics($html);
}
 