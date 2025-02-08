
<html>
  <head>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
    margin-bottom: 10px;
}

.ingredient-list,
.recipe-list {
    list-style-type: none;
    padding: 0;
}

.ingredient-list li,
.recipe-list li {
    margin: 10px 0;
    padding: 10px;
    background: #e9ecef;
    border-radius: 4px;
}

.recipe-name {
    color: #007bff; /* Bootstrap primary color */
    cursor: pointer;
}

.recipe-name:hover {
    text-decoration: underline; /* Add underline on hover */
}

.recipe-steps {
    padding: 10px;
    background: #f8f9fa;
    border-left: 4px solid #007bff; /* Blue border to the left */
    border-radius: 4px;
    margin-top: 5px;
}

.error {
    color: red;
    font-weight: bold;
    margin: 20px 0;
}

    </style>
  </head>
  <body>
    <div style="width: 100%; text-align:center;background-color: blue; color: white;padding: 10px;"> We are here with your favourite vietnese cousine</div>
  </body>
</html>

<?php
// Check if form data has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch the ingredients
    $ingredient1 = $_POST['ingredient1'];
    $ingredient2 = $_POST['ingredient2'];
    $ingredient3 = $_POST['ingredient3'];
    $ingredient4 = $_POST['ingredient4'];
    $ingredient5 = $_POST['ingredient5'];

    // Prepare the command to run the Java program
    $str = "java -cp D:\softwareEngineering\java\out\production\java\ Main";
    
    // Print the ingredients
    echo "<div class='container'>";
    echo "<h2>Submitted Ingredients</h2>";
    echo "<ul class='ingredient-list'>";
    echo "<li>" . htmlspecialchars($ingredient1) . "</li>";
    echo "<li>" . htmlspecialchars($ingredient2) . "</li>";
    $a = escapeshellarg($ingredient1);
    $b = escapeshellarg($ingredient2);
    $str .= " $a $b";
    
    if (!empty($ingredient3)) {
        echo "<li>" . htmlspecialchars($ingredient3) . "</li>";
        $str .= " ".escapeshellarg($ingredient3);
    }
    if (!empty($ingredient4)) {
        echo "<li>" . htmlspecialchars($ingredient4) . "</li>";
        $str .= " ".escapeshellarg($ingredient4);
    }
    if (!empty($ingredient5)) {
        echo "<li>" . htmlspecialchars($ingredient5) . "</li>";
        $str .= " ".escapeshellarg($ingredient5);
    }
    
    echo "</ul>";

    // Execute the Java program and decode JSON output
    $jsonData = exec(escapeshellcmd($str));
    $recipes = json_decode($jsonData, true);

    // Check if decoding was successful
    if ($recipes === null) {
        echo "<p class='error'>Invalid JSON or error in decoding!</p>";
        exit();
    }

    // Display recipes
    echo "<h2>Recipes</h2>";
    // Get the total number of recipes
$totalRecipes = count($recipes);

// Determine how many items to initially display
$initialDisplayCount = $totalRecipes < 3 ? $totalRecipes : 3;

// Render the recipe list
if (!empty($recipes)) {
    echo "<ul class='recipe-list' id='recipe-list'>";
    for ($i = 0; $i < $initialDisplayCount; $i++) {
        $name = htmlspecialchars($recipes[$i]['name'], ENT_QUOTES);
        $recipeSteps = htmlspecialchars($recipes[$i]['recipie'], ENT_QUOTES);
        $ingredients = htmlspecialchars($recipes[$i]['ingredient'], ENT_QUOTES);

        echo "<li>
                <strong class='recipe-name' onclick='toggleRecipe(\"recipe-{$name}\")'>{$name}</strong>
                <div class='recipe-steps' id='recipe-{$name}' style='display: none;'>
                    <p>{$recipeSteps}</p>
                    <strong onclick='toggleRecipe(\"ingredients-{$name}\")' style='cursor: pointer;'>Show Ingredients</strong>
                    <div class='recipe-ingredients' id='ingredients-{$name}' style='display: none;'>{$ingredients}</div>
                </div>
              </li>";
    }
    echo "</ul>";

    // Add "Show All" button if there are more than 3 recipes
    if ($totalRecipes > 3) {
        echo "<button id='show-all-button' onclick='showAllRecipes()'>Show All</button>";
    }
} else {
    echo "<p class='no-recipes'>No recipes available.</p>";
}

echo "</div>"; // Close container
} else {
    header('Location: index.php');
}
?>


<script>
    function toggleRecipe(elementId) {
        var element = document.getElementById(elementId);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }

    function showAllRecipes() {
        var recipeList = document.getElementById('recipe-list');
        var allRecipes = <?php echo json_encode($recipes); ?>;
        recipeList.innerHTML = ''; // Clear the current list

        // Render all recipes
        allRecipes.forEach(function(recipe) {
            var name = recipe.name.replace(/'/g, "\\'"); // Escape single quotes
            var stepsId = "recipe-" + name;
            var ingredientsId = "ingredients-" + name;

            recipeList.innerHTML += `
                <li>
                    <strong class='recipe-name' onclick='toggleRecipe("${stepsId}")'>${recipe.name}</strong>
                    <div class='recipe-steps' id='${stepsId}' style='display: none;'>
                        <p>${recipe.recipie}</p>
                        <strong onclick='toggleRecipe("${ingredientsId}")' style='cursor: pointer;'>Show Ingredients</strong>
                        <div class='recipe-ingredients' id='${ingredientsId}' style='display: none;'>${recipe.ingredient}</div>
                    </div>
                </li>`;
        });

        // Hide the "Show All" button
        document.getElementById('show-all-button').style.display = 'none';
    }
</script>
