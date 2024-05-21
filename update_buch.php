<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['kurztitle'], $_POST['autor'])) {
        $id = $_POST['id'];
        $kurztitle = $_POST['kurztitle'];
        $autor = $_POST['autor'];

        $sql = "UPDATE buecher SET kurztitle = :kurztitle, autor = :autor WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':kurztitle', $kurztitle, PDO::PARAM_STR);
        $stmt->bindParam(':autor', $autor, PDO::PARAM_STR);
        if ($stmt->execute()) {
            header("Location: index.php?id=$id");
            exit;
        }
    }
}
?>
