<?php
/**
 * Part of softvilla project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace SMS\Seeder;

use Windwalker\Console\Command\Command;
use Windwalker\Utilities\Reflection\ReflectionHelper;

/**
 * The AbstractSeeder class.
 * 
 * @since  {DEPLOY_VERSION}
 */
abstract class AbstractSeeder
{
	/**
	 * Property db.
	 *
	 * @var \JDatabaseDriver
	 */
	protected $db;

	/**
	 * Property io.
	 *
	 * @var Command
	 */
	protected $command;

	/**
	 * Class init.
	 *
	 * @param \JDatabaseDriver $db
	 * @param Command          $command
	 */
	public function __construct(\JDatabaseDriver $db = null, Command $command = null)
	{
		$this->db = $db;
		$this->command = $command;
	}

	/**
	 * execute
	 *
	 * @param AbstractSeeder|string $seeder
	 *
	 * @return  static
	 */
	public function execute($seeder = null)
	{
		if (is_string($seeder))
		{
			include_once dirname(ReflectionHelper::getPath(get_called_class())) . '/' . $seeder . '.php';

			$seeder = new $seeder;
		}

		$seeder->setDb($this->db)
			->setCommand($this->command);

		$seeder->doExecute();

		return $this;
	}

	/**
	 * doExecute
	 *
	 * @return  void
	 */
	abstract public function doExecute();

	/**
	 * clean
	 *
	 * @param AbstractSeeder|string $seeder
	 *
	 * @return  static
	 */
	public function clean($seeder = null)
	{
		if (is_string($seeder))
		{
			include_once dirname(ReflectionHelper::getPath(get_called_class())) . '/' . $seeder . '.php';

			$seeder = new $seeder;
		}

		$seeder->setDb($this->db);
		$seeder->setCommand($this->command);

		$seeder->doClean();

		return $this;
	}

	/**
	 * doClean
	 *
	 * @return  void
	 */
	public function doClean()
	{
		// Override it.
	}

	/**
	 * Method to get property Db
	 *
	 * @return  \JDatabaseDriver
	 */
	public function getDb()
	{
		return $this->db;
	}

	/**
	 * Method to set property db
	 *
	 * @param   \JDatabaseDriver $db
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setDb(\JDatabaseDriver $db)
	{
		$this->db = $db;

		return $this;
	}

	/**
	 * Method to get property Command
	 *
	 * @return  Command
	 */
	public function getCommand()
	{
		return $this->command;
	}

	/**
	 * Method to set property command
	 *
	 * @param   Command $command
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setCommand(Command $command)
	{
		$this->command = $command;

		return $this;
	}
}
