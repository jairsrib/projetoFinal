<?php
class Noticia
{

   private $conn;
   private $table_name = "noticias";
   public function __construct($db)
   {
      $this->conn = $db;
   }

   public function registrar($titulo, $texto, $data, $autor_id, $categoria, $imagem)
   {
      $query = "INSERT INTO " . $this->table_name . " (
      titulo, texto, data, autor_id, categoria, imagem
   ) VALUES (?, ?, ?, ?, ?, ?)";

      $stmt = $this->conn->prepare($query);
      $stmt->execute([$titulo, $texto, $data, $autor_id, $categoria, $imagem]);
      return $stmt;
   }

   public function buscarTodasOrdenadas()
   {
      $query = "SELECT * FROM noticias ORDER BY data DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function criar($titulo, $texto, $data, $autor_id, $categoria, $imagem)
   {
      return $this->registrar($titulo, $texto, $data, $autor_id, $categoria, $imagem);
   }
   public function ler()
   {
      $query = "SELECT * FROM " . $this->table_name;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
   }
   public function lerPorId($id)
   {
      $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$id]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }
   public function atualizar($titulo, $texto, $data, $autor_id, $categoria, $imagem)
   {
      $query = "UPDATE " . $this->table_name . " SET titulo = ?, texto =
    ?, data = ?, autor_id = ?, imagem = ? WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$titulo, $texto, $data, $autor_id, $categoria, $imagem]);
      return $stmt;
   }
   public function deletar($id)
   {
      $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$id]);
      return $stmt;
   }
}
?>