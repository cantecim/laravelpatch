<?php
/**
 * Created by PhpStorm.
 * User: Can
 * Date: 15.1.2015
 * Time: 20:52
 */

namespace cantecim\Database\Connectors;


use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\Connectors\SQLiteConnector;
use Illuminate\Database\Connectors\SqlServerConnector;

class ConnectionFactory extends \Illuminate\Database\Connectors\ConnectionFactory {

	/**
	 * Create a connector instance based on the configuration.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Database\Connectors\ConnectorInterface
	 *
	 * @throws \InvalidArgumentException
	 */
	public function createConnector(array $config)
	{
		if ( ! isset($config['driver']))
		{
			throw new \InvalidArgumentException("A driver must be specified.");
		}

		if ($this->container->bound($key = "db.connector.{$config['driver']}"))
		{
			return $this->container->make($key);
		}

		switch ($config['driver'])
		{
			case 'mysql':
				return new MySqlConnector;

			case 'pgsql':
				return new PostgresConnector;

			case 'sqlite':
				return new SQLiteConnector;

			case 'sqlsrv':
				return new SqlServerConnector;
		}

		throw new \InvalidArgumentException("Unsupported driver [{$config['driver']}]");
	}

} 