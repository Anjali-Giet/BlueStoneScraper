<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bluestone Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Bluestone Products</h1>
    <div id="products">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = ""; // No password if using default setup
        $dbname = "bluestone";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from database
        $sql = "SELECT title, price, link FROM products"; // Adjust column names as per your table structure
        $result = $conn->query($sql);

        if ($result === FALSE) {
            echo "Error executing SQL: " . $conn->error;
        } elseif ($result->num_rows > 0) {
            // Output data for each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<h2>' . htmlspecialchars($row["title"]) . '</h2>'; // Adjust column name here
                echo '<p class="price">Price: ' . htmlspecialchars($row["price"]) . '</p>'; // Adjust column name here
                echo '<a href="' . htmlspecialchars($row["link"]) . '" target="_blank">View Product</a>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
