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
		$uri = new \JUri($url);

		$uri->setScheme('');

		$url = $uri->toString();

		$result = 0;

		// Only url
		$this->engine->getState()->set('keyword', $url);

		$result += (int) $this->countWebometrics($this->engine->getPage(1));

		// Add site:...
		$this->engine->getState()->set('keyword', 'site:' . $url);

		$result += (int) $this->countWebometrics($this->engine->getPage(1));

		// PDF
		$this->engine->getState()->set('keyword', 'site:' . $url . ' filetype:pdf');

		$result += (int) $this->countWebometrics($this->engine->getPage(1));

		// PPT
		$this->engine->getState()->set('keyword', 'site:' . $url . ' filetype:ppt');

		$result += (int) $this->countWebometrics($this->engine->getPage(1));

		// DOC
		$this->engine->getState()->set('keyword', 'site:' . $url . ' filetype:doc');

		$result += (int) $this->countWebometrics($this->engine->getPage(1));

		return $result;
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
 