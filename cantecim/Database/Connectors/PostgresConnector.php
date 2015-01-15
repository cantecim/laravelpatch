<?php
/**
 * Created by PhpStorm.
 * User: Can
 * Date: 15.1.2015
 * Time: 20:54
 */

namespace cantecim\Database\Connectors;


class PostgresConnector extends \Illuminate\Database\Connectors\PostgresConnector {

	/**
	 * Establish a database connection.
	 *
	 * @param  array  $config
	 * @return \PDO
	 */
	public function connect(array $config)
	{
		// First we'll create the basic DSN and connection instance connecting to the
		// using the configuration option specified by the developer. We will also
		// set the default character set on the connections to UTF-8 by default.
		$dsn = $this->getDsn($config);

		$options = $this->getOptions($config);

		$connection = $this->createConnection($dsn, $config, $options);

		$charset = $config['charset'];

		$connection->prepare("set names '$charset'")->execute();

		if(isset($config['timezone']))
			$connection->prepare("set timezone='" . $config['timezone'] . "'")->execute();

		// Unlike MySQL, Postgres allows the concept of "schema" and a default schema
		// may have been specified on the connections. If that is the case we will
		// set the default schema search paths to the specified database schema.
		if (isset($config['schema']))
		{
			$schema = $config['schema'];

			$connection->prepare("set search_path to {$schema}")->execute();
		}

		return $connection;
	}

} 