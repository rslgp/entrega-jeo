<?php

function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

//$host = "localhost";
//$username = "root";
//$password = "";
//$database = "test";
//
////$conn = mysqli_connect($host, $username, $password, $database) OR die("Error connecting to MySQL: " . //mysqli_connect_error());;
//
//$conn = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);
//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//PEPARE TABLE from zero
//$sql = "CREATE TABLE games (
//    Game_id INT KEY AUTO_INCREMENT,
//    nome VARCHAR(255),
//    price DECIMAL(4,2),
//    is_spicy INT
//)";


//$result = mysqli_query($conn, $sql);
//
//if ($result === false) {
//  die("Error executing SQL query: " . mysqli_error($conn));
//}

//CREATE simple sql injection vulnerability 
/* 
$sql = "INSERT INTO games (
    nome,
    price,
    is_spicy
)
VALUES ('sorvete', 5, 0)";


$result = mysqli_query($conn, $sql);

if ($result === false) {
  die("Error executing SQL query: " . mysqli_error($conn));
}
 */

//CREATE
//to avoid sql injection
function insertGame($pdo, $args) {
    try {
        // Prepare the INSERT statement with named placeholders
        $stmt = $pdo->prepare("INSERT INTO games (nome, genero, valor, plataforma) 
                    VALUES (:nome, :genero, :valor, :plataforma)");
        
        // Bind parameters
        $stmt->bindParam(':nome', $args['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':genero', $args['genero'], PDO::PARAM_STR);
        $stmt->bindParam(':valor', $args['valor'], PDO::PARAM_STR);
        $stmt->bindParam(':plataforma', $args['plataforma'], PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();
        
        return true; // Insertion successful
    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}
//usage
//$args = array('nome' => 'Spicy Chicken', 'price' => 10, 'is_spicy' => 1);
//insertGame($pdo, $args);


////SIMPLE READ
//$sql = "SELECT * FROM games";
//
//$stmt = $conn->prepare($sql);
//$stmt->execute();
//$rows = $stmt->fetchAll();
//
//print '<table><tr><th>numero</th><th>string</th></tr>';
//foreach ($rows as $row){
//    print "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
//}
//print '</table>';

//READ SIMPLE
/* 
$info="sorvete";
$sql = "SELECT * FROM games WHERE nome = '$info'";
$result = mysqli_query($conn, $sql) OR die("Error: " . mysqli_error($mysqli));

while ($row = mysqli_fetch_assoc($result)) {
    echo "name: " . $row["nome"] . ", price: " . $row["price"] . "<br>";
}
 */

//READ ONCE
// Function to retrieve data securely
function getGameByGameName($pdo, $nome) {
    try {
        // Prepare the statement with a named placeholder
        $stmt = $pdo->prepare("SELECT * FROM games WHERE nome = :nome");
        
        // Bind the parameter
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the result as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user;
    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}

// Usage
//$usernameToRetrieve = 'sorvete';
//$user = getGameByGameName($conn, $usernameToRetrieve);
//echo $user;

//READ ALL
function getAllgames($pdo) {
    try {
        // Prepare the statement
        $stmt = $pdo->prepare("SELECT * FROM games");
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch all results as an associative array
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $games;
    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}

function printAllGames($pdo){
    print '
    <table>
        <tr>
            <th>Nome do Jogo</th>
            <th>Gênero</th>
            <th>Valor</th>
            <th>Plataforma</th>
            <th>Ações</th>
        </tr>';
    foreach (getAllgames($pdo) as $row){
        echo "<tr id=".$row['id'].">";
        echo "<td>".$row['nome'].$row['id']."</td>";
        echo "<td>".$row['genero']."</td>";
        echo "<td>".$row['valor']."</td>";
        echo "<td>".$row['plataforma']."</td>";
        echo '<td>
        <div class="formulario">
            <button id="editar" onClick="editGame('.$row['id'].')">Editar</button>
            <button id="excluir" onClick="deleteGame('.$row['id'].')">Excluir</button>
            
        </div>
    </td>';
        echo "</tr>";
    }
    print '</table>';
}




//UPDATE
function update($conn, $args){
// Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("UPDATE games SET nome=:nome, genero=:genero, valor=:valor, plataforma=:plataforma WHERE id=:id");
        
        // Bind parameters
        $stmt->bindParam(':id', $args['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $args['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':genero', $args['genero'], PDO::PARAM_STR);
        $stmt->bindParam(':valor', $args['valor'], PDO::PARAM_STR);
        $stmt->bindParam(':plataforma', $args['plataforma'], PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
    echo "Game updated successfully!";
    } else {
    echo "Failed to add Game.";
    }
}
//update($conn,"2","mousse",4,0);


//DELETE
function deleteGameByGameName($pdo, $nome) {
    try {
        // Prepare the statement with a named placeholder
        $stmt = $pdo->prepare("DELETE FROM games WHERE nome = :nome");
        
        // Bind the parameter
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();

    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}

function deleteGame($pdo, $id) {
    try {
        // Prepare the statement with a named placeholder
        $stmt = $pdo->prepare("DELETE FROM games WHERE id = :id");
        
        // Bind the parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Execute the statement
        $stmt->execute();

    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}

//$usernameToRetrieve = 'sorvete';
//deleteGameByGameName($conn, $usernameToRetrieve);



?>
