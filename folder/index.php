<?php
session_start();
if(!isset($_SESSION['username'])){
  echo "invalid";
  header('Location: login.html');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ingredient Input Form</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0; /* Light background for contrast */
}

.form-container {
    position: relative;
    top: 20px;
    max-width: 500px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #ffffff; /* White background for form */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

h2 {
    text-align: center;
    color: #666;
}

label {
    font-weight: bold;
    color: #555;
    margin-bottom: 5px; /* Space between label and input */
}

input[type="text"] {
  margin: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%; /* Full width */
    box-sizing: border-box; /* Ensures padding is included in width */
}

button {
    padding: 10px;
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

    </style>
  </head>
  <body>
    <div style="position: relative;top:20px" class="form-container">
    
    <h1><?php echo " WELCOME ".$_SESSION['username']; ?></h1>
      <h2>Enter Ingredients</h2>
      <form action="ingredients.php" method="POST">
        <label for="ingredient1">Ingredient 1:</label>
        <input type="text" id="ingredient1" name="ingredient1" required /><br />

        <label for="ingredient2">Ingredient 2:</label>
        <input type="text" id="ingredient2" name="ingredient2" required /><br />

        <label for="ingredient3">Ingredient 3:</label>
        <input type="text" id="ingredient3" name="ingredient3" /><br />

        <label for="ingredient4">Ingredient 4:</label>
        <input type="text" id="ingredient4" name="ingredient4" /><br />

        <label for="ingredient5">Ingredient 5:</label>
        <input type="text" id="ingredient5" name="ingredient5" /><br />

        <button type="submit">Submit</button>
      </form>
    </div>
  </body>
</html>
