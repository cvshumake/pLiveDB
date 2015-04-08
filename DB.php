<?php

// Setup
$ip = '127.0.0.1';
$port = 3310;
$username = 'FIXME';
$password = 'FIXME';
$dbName = 'world';

// Options control how statements work
$options = array(
	// Errors should throw exceptions
	PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
	// Fetch associative array
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	// No conversion of nulls
	PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
	);

// PDO objects are connections
$Pdo = new PDO("mysql:host=$ip;dbname=$dbName;port=$port", $username, $password, $options);
echo "Pdo Var Dump:\n";
var_dump($Pdo);

// SQL statements, with injection prevention, look like this:
$sql = 'SELECT * FROM City WHERE ID = ' . $Pdo->quote(4);
$pdoStatement = $Pdo->query($sql);
echo "SQL Statement output:\n";
print_r($pdoStatement->fetchAll());

// Prepared statements, with injection prevention, look like this:
$sql = 'SELECT * FROM City WHERE ID = :id';
$pdoStatement = $Pdo->prepare($sql);
// PdoStatements are the returned object from both Query and Prepare, so keep track of which you use.
$pdoStatement->execute(array('id' => 4));
echo "Prepared Statement output:\n";
print_r($pdoStatement->fetchAll());

// Prepared Statements, without injection prevention, do not use parameters:
$userProvidedData = '4"; DRP DATABASE world';
$sql = 'SELECT * FROM City WHERE ID = "' . $userProvidedData . '"';


// Prepared Statement Example
$sql = 'SELECT * FROM City WHERE Name = :name LIMIT 3';
$pdoStatement = $Pdo->prepare($sql);
$pdoStatement->execute(array('name' => 'Kabul'));
echo "Prepared Statement Example:\n";
print_r($pdoStatement->fetchAll());

// Prepared Statement Example: Re-use without re-preparing
$sql = 'SELECT * FROM City WHERE Name = :name LIMIT 3';
$pdoStatement = $Pdo->prepare($sql);
$pdoStatement->execute(array('name' => 'Kabul'));
echo "Prepared Statement Example: Re-use w/out re-preparing:\n";
print_r($pdoStatement->fetchAll());
$pdoStatement->execute(array('name' => 'Qandahar'));
print_r($pdoStatement->fetchAll());
$pdoStatement->execute(array('name' => 'Herat'));
print_r($pdoStatement->fetchAll());

// Prepared Statement Example: Re-use Handle
$sql = 'SELECT * FROM City WHERE Name = :name LIMIT 3';
$cache = array();
$cache[$sql] = $Pdo->prepare($sql);
$cache[$sql]->execute(array('name' => 'Kabul'));
echo "Prepared Statement Example: Re-use Handle:\n";
print_r($cache[$sql]->fetchAll());
$cache[$sql]->execute(array('name' => 'Qandahar'));
print_r($cache[$sql]->fetchAll());
$cache[$sql]->execute(array('name' => 'Herat'));
print_r($cache[$sql]->fetchAll());










// The remainder is psuedocode
echo "Remainder is psuedocode.\n";
exit; 

/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////        PSUEDOCODE BELOW   //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

// Prepared Statement Example: Object Instantiation
class City {}
$cache[$sql]->execute(array('name' => 'Kabul'));
print_r($cache[$sql]->fetchAll(PDO::FETCH_CLASS, 'City'));

// Prepared Statment Example: Caching Connections & Handles
// Connections are not singletons
class DBConnection extends PDO {
	// Connections hold their own prepared statement cache
	private $preparedStatementCache;
	public function connect() {
		// Always ensure that a reconnect clears the statement cache
		$this->preparedStatementCache = array();
	}
}
// DBWrapper is fine to have as a Singleton
class DB extends Singleton {
	// Wrapper caches its own connections
	private $dbConnectionCache = array();
	public function find($modelName, $args, $useCache=true) {}
	// Wrapper does not stop clients from getting their own conns
	public static function getDBHandle() {}
}

// Prepared Statement Example: Error Handling
// Connections can fail
$tries = 0;
do {
	try {
		$tries++;
		$pdo = new PDO($dsn, $user, $pass, $opts);
	} catch (Exception $e) {
		if ($tries > 4) {
			throw $e;
		}
		if (!DB::isRetryable($e)) {
			throw $e;
		}
		usleep(rand(0,100000));
	}
} while (!$pdo);

// Prepared Statement Example: Error Handling
// Prepared Statements Can Fail
if (!$preparedStatementHandleCache->is_set($sql)) {
	$loops = 0;
	while (true) {
		$loops++;
		try {
			$preparedStatementHandleCache->set($sql, $pdoHandle->prepare($sql));
			break;
		} catch (Exception $e) {
			// Enable prepared statement emulation last before failing
			if ($loops > 2) {
				$pdoHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
				continue;
			}
			// Example unobfuscated error code handling
			if (in_array($e->getCode(), array(1461))) {
				$preparedStatementHandleCache->purge();
				continue;
			}
			throw $e;
		}
	}
}
$pdoStatement = $preparedStatementHandleCache->get($sql);
$pdoStatement->execute(array('name' => 'Kabul'));
print_r($pdoStatement->fetchAll());


// See the CustomDB checkout for a more advanced implementation of a DB Wrapper
