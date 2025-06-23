<?php
class Noticia {
    
 private $conn;
 private $table_name = "noticias";
 public function __construct($db) {
  $this->conn = $db; 
 }
 
 public function registrar($titulo, $texto, $data, $autor_id, $imagem) {
    $query = "INSERT INTO " . $this->table_name . " (titulo,
    texto, data, autor_id, imagem) VALUES ( ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$titulo, $texto, $data, $autor_id, $imagem]);
    return $stmt;
 }
 

 public function criar($titulo, $texto, $data, $autor_id, $imagem) {
    return $this->registrar($titulo, $texto, $data, $autor_id, $imagem);
 }
 public function ler() {
    $query = "SELECT * FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
 }
 public function lerPorId($id) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
 }
 public function atualizar($id, $nome, $sexo, $fone, $email) {
    $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo =
    ?, fone = ?, email = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$nome, $sexo, $fone, $email, $id]);
    return $stmt;
 }
 public function deletar($id) {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt;
 }
}
?>