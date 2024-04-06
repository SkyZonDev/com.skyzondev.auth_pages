# Documentation 📄

This is a registration and login system.

For configure your server, go to `process\config.php` file.

```php
<?php
	// Localhost exemple
	$host  =  'localhost'; // Database server address
	$database  =  'MyDatabase'; // Database name
	$usr  =  'root'; // Database username
	$pwd  =  ''; // Database password
	try {
		$pdo  =  new  PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $usr, $pwd);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException  $e) {
		die("Database connection error : "  .  $e->getMessage());
	}
?>
```

### Enjoy it 🚀