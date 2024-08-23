<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bluestone";
$csv_file = "C:\\Users\\Anjali Kumari\\Documents\\produc.csv";  // Correct path to the CSV file

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS products (
    title VARCHAR(255) NOT NULL,
    price VARCHAR(50),
    link TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table products created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Open the CSV file
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    fgetcsv($handle); // Skip header row

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO products (title, price, link) VALUES (?, ?, ?)");

    // Check if the statement was prepared successfully
    if ($stmt === FALSE) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sss", $title, $price, $link);

    // Read CSV file line by line
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $title = $data[0];
        $price = $data[1];
        $link = $data[2];

        // Execute the prepared statement
        if (!$stmt->execute()) {
            echo "Error executing statement: " . $stmt->error . "<br>";
        } else {
            echo "Inserted: $title, $price, $link<br>";
        }
    }

    // Close the file handle and statement
    fclose($handle);
    $stmt->close();
    echo "Data imported successfully<br>";
} else {
    echo "Error opening the file.<br>";
}

// Close the database connection
$conn->close();
?>
