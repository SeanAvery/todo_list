<?php
// Databases
// Review: A place where you can store structured and persistent data
//             - Structured: the data is stored in tables with columns, which are
//                           defined in a specific format called a schema
// More formally: the schema is the set of tables and their columns.
// for example, the schema of the 'aca' database is a table called 'customers'
// which has 4 columns: id, firstname, lastname, and phonenumber.

//             - Persistent: the data lives on your server, and so it lasts beyond
//                           the life of the current web request. It even stays
//                           around if your server restarts.

// 4 basic operations: CRUD
// Create: INSERT INTO customer (name, email) VALUES ("Shirley", "shirley@gmail.com");
// Read:   SELECT * FROM customer WHERE name = "John";
// Update: UPDATE customer SET name="Jon" WHERE name="John" AND customer_id = 1;
// Delete: DELETE FROM customer WHERE customer_id = 5;

// Creating some example tables from the command line
// 1. WINDOWS: cd \vm
//    MAC OS : cd Desktop/VirtualMachines
// 2. vagrant ssh
// 3. mysql -u root -proot

// CREATE DATABASE intro_to_php;
// CREATE TABLE todo_list (id INT AUTO_INCREMENT, item TEXT, 
//                         PRIMARY KEY(id));

// Using this stuff from PHP

// Creating a connection
// mysqli's __construct takes 4 things: a database server address, a username,
// a password, and a database name
// (http://php.net/manual/en/mysqli.quickstart.connections.php)
// localhost == 127.0.0.1 (Same server as the one running the PHP)

$db = new mysqli("localhost", "root", "root", "intro_to_php");
if ($db->connect_errno) {
  echo "Failed to connect to MySQL :(<br>";
  echo $db->connect_error;
  exit();
}
// Running queries
// We use the method `prepare` to load an INSERT SQL statement in PHP.


if(isset($_POST['submit']))
{
	// add input to database
	echo "<table border='1'> ";
		echo "<tr>";
			echo "<th>To Do</th>";
			echo "<th>Date Added</th>";
		echo "</tr>";
	$stmt = $db->prepare("INSERT INTO todo_list (item, timestamp) VALUES (?,?)");
	$item = $_POST['todo'];
	$date = date('m/d/Y h:i:s', time());
	$stmt->bind_param("ss", $item, $date);
	$stmt->execute();
	$sql = "SELECT * FROM todo_list";

	//query database and display reult
	$result = $db->query($sql);
	if ($result) 
	{

  		foreach ($result as $row) 
  		{
   	 		echo "<tr><td>".$row['item']."</td><td>".$row['timestamp']."</td><td>";  

   	 		echo "<form action='inclass8.php' method='POST'>";
    		echo "<input type='hidden' name='id' value='$row[id]'>";
    		echo "<input type='submit' name='delete' value='delete'>";
    		echo "</form></td></tr>";
  		}

	} 
	else 
	{
  		echo $db->error;
	}

	echo "<table>";
}

else if (isset($_POST['delete']))
{
	$id = $_POST['id'];
	$blargle = $db->prepare("DELETE FROM todo_list Where id = ?");
	$blargle->blind_param("i", $id);
	$blargle->execute();

}
else 
{

}



// Programming Assignment 1:
// Modify the to-do list page from last class to use MySQL.
// When the "submit" button is clicked, add a row to the todo_list table
// containing the value of the text field.

// When the page is loaded, display all of the todo items.
?>

<!-- More HTML: Tables -->

<form action="inclass8.php" method="POST">
	I need to:
	<input type="text" name="todo">
	<input type="submit" name="submit">
</form>

