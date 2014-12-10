<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace SMS\Seeder\Command\Seed;

use Windwalker\Console\Command\Command;
use Windwalker\String\StringNormalise;

/**
 * Class Seed
 */
class ImportCommand extends Command
{
	/**
	 * An enabled flag.
	 *
	 * @var bool
	 */
	public static $isEnabled = true;

	/**
	 * Console(Argument) name.
	 *
	 * @var  string
	 */
	protected $name = 'import';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'Import seed';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'import <cmd><command></cmd> <option>[option]</option>';

	/**
	 * Initialise command information.
	 *
	 * @return void
	 */
	public function initialise()
	{
		parent::initialise();
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		$class = $this->getOption('class');

		$class = StringNormalise::toClassNamespace($class);

		if (!class_exists($class))
		{
			throw new \RuntimeException('Class: ' . $class . ' not exists.');
		}

		if (!is_subclass_of($class, 'SMS\Seeder\AbstractSeeder'))
		{
			throw new \RuntimeException('Class: ' . $class . ' should be sub class of SMS\Seeder\AbstractSeeder.');
		}

		/** @var \SMS\Seeder\AbstractSeeder $seeder */
		$seeder = new $class(\JFactory::getDbo(), $this);

		$seeder->doExecute();

		return true;
	}
}
