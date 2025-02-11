<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compatibility Result</title>
    <link rel="stylesheet" href="style.css">
    <style>
        video {
            position: fixed;
            top: -95px;
            right: -180px;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            height: 115.5%;
            width: 112.5%;
        }
    </style>
</head>
<body>
    <div>
        <video id="video" autoplay muted preload="auto" poster="http://cupid.byethost7.com/assets/bgbaloon.png">
            <source src="http://cupid.byethost7.com/assets/bgball.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="container">
        <h1>Your Compatibility Result</h1>
      <p style="margin-top: 20px; font-size: 1.4em;">     
    <script>
        // Extract variables from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const name1 = urlParams.post('name1');
        const age1 = urlParams.post('age1');
        const sign1 = urlParams.post('sign1');
        const name2 = urlParams.post('name2');
        const age2 = urlParams.post('age2');
        const sign2 = urlParams.post('sign2');

        // Send data to PHP for processing
        fetch('com.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `name1=${name1}&age1=${age1}&sign1=${sign1}&name2=${name2}&age2=${age2}&sign2=${sign2}`
        })
        .then(response => response.text())
        .then(data => {
            // Display the result from PHP
            document.getElementById('result').textContent = data;
        })
        .catch(error => console.error('Error:', error));

    
    </script>

    <?php
// PHP Section for Processing Compatibility
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "sql313.byethost7.com";
    $username = "b7_37308076";
    $password = "elonmusk69";
    $dbname = "b7_37308076_Cupid";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve POST data
    $n1 = $_POST['name1'];
    $a1 = $_POST['age1'];
    $s1 = $_POST['sign1'];
    $n2 = $_POST['name2'];
    $a2 = $_POST['age2'];
    $s2 = $_POST['sign2'];

    // Check if compatibility result exists in the database
    $stmt = $conn->prepare("SELECT compatibilityScore FROM compatibility WHERE name1=? AND age1=? AND sign1=? AND name2=? AND age2=? AND sign2=?");
    $stmt->bind_param("sissis", $n1, $a1, $s1, $n2, $a2, $s2);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();

    if ($result) {
        // If result exists, display it
        echo "\n"."💖 $n1 and $n2 have a compatibility score of $result% 💖";
    } else {
        // If result does not exist, calculate it
        $compScore = rand(1, 100);
        $resdata = "\n"."💖 $n1 and $n2 have a compatibility score of $compScore% 💖";

        // Get the current number of rows to set the new ID
        $countResult = $conn->query("SELECT COUNT(*) AS count FROM compatibility");
        $row = $countResult->fetch_assoc();
        $currentCount = $row['count'] + 1;

        // Insert the new result into the database
        $stmt = $conn->prepare("INSERT INTO compatibility (id, name1, age1, sign1, name2, age2, sign2, compatibilityScore) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isissisi", $currentCount, $n1, $a1, $s1, $n2, $a2, $s2, $compScore);
        $stmt->execute();
        $stmt->close();

        // Display the new result
        echo $resdata;

    }

    // Close the database connection
    $conn->close();
    exit; // End PHP execution here so that the rest of the page does not load
}
?>
</p>
</div>
</body>
</html>
