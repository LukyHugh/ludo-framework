<?php
namespace Ludo\Support;

class AliasLoader
{

	/**
	 * The array of class aliases.
	 *
	 * @var array
	 */
	protected $aliases;

	/**
	 * Indicates if a loader has been registered.
	 *
	 * @var bool
	 */
	protected $registered = false;

	/**
	 * The singleton instance of the loader.
	 *
	 * @var \Ludo\Support\AliasLoader
	 */
	protected static $instance;

	/**
	 * Create a new class alias loader instance.
	 *
	 * @param  array  $aliases
	 */
	public function __construct(array $aliases = array())
    {
		$this->aliases = $aliases;
	}

	/**
	 * Get or create the singleton alias loader instance.
	 *
	 * @param  array  $aliases
	 * @return \Ludo\Support\AliasLoader
	 */
	public static function getInstance(array $aliases = array())
    {
		if (is_null(self::$instance)) self::$instance = new self($aliases);

		$aliases = array_merge(self::$instance->getAliases(), $aliases);

		self::$instance->setAliases($aliases);

		return self::$instance;
	}

	/**
	 * Load a class alias if it is registered.
	 *
	 * @param  string  $alias
	 * @return bool
	 */
	public function load($alias)
    {
		if (isset($this->aliases[$alias])) {
			return class_alias($this->aliases[$alias], $alias);
		}
        return false;
	}

	/**
	 * Add an alias to the loader.
	 *
	 * @param  string  $class
	 * @param  string  $alias
	 * @return void
	 */
	public function alias($class, $alias)
    {
		$this->aliases[$class] = $alias;
	}

	/**
	 * Register the loader on the auto-loader stack.
	 *
	 * @return void
	 */
	public function register()
    {
		if (!$this->registered) {
			$this->prependToLoaderStack();
			$this->registered = true;
		}
	}

	/**
	 * Prepend the load method to the auto-loader stack.
	 *
	 * @return void
	 */
	protected function prependToLoaderStack()
    {
		spl_autoload_register(array($this, 'load'), true, true);
	}

	/**
	 * Get the registered aliases.
	 *
	 * @return array
	 */
	public function getAliases()
    {
		return $this->aliases;
	}

	/**
	 * Set the registered aliases.
	 *
	 * @param  array  $aliases
	 * @return void
	 */
	public function setAliases(array $aliases)
    {
		$this->aliases = $aliases;
	}

	/**
	 * Indicates if the loader has been registered.
	 *
	 * @return bool
	 */
	public function isRegistered()
    {
		return $this->registered;
	}

	/**
	 * Set the "registered" state of the loader.
	 *
	 * @param  bool  $value
	 * @return void
	 */
	public function setRegistered($value)
    {
		$this->registered = $value;
	}
}
