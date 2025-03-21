<?php
interface Crud {
    public function create($data);
    public function read();
    public function update($id, $data);
    public function delete($id);
}

class LibroCrud implements Crud {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO libros (NombreL, Descripcion, Id_autor, Id_categoria) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $data['NombreL'], $data['Descripcion'], $data['Id_autor'], $data['Id_categoria']);
        return $stmt->execute();
    }

    public function read() {
        $result = $this->db->query("SELECT * FROM libros");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE libros SET NombreL=?, Descripcion=?, Id_autor=?, Id_categoria=? WHERE Id_libro=?");
        $stmt->bind_param("ssisi", $data['NombreL'], $data['Descripcion'], $data['Id_autor'], $data['Id_categoria'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM libros WHERE Id_libro=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

class AutorCrud implements Crud {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO autores (NombreA, Nacionalidad, Fecha_nacimiento) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['NombreA'], $data['Nacionalidad'], $data['Fecha_nacimiento']);
        return $stmt->execute();
    }

    public function read() {
        $result = $this->db->query("SELECT * FROM autores");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE autores SET NombreA=?, Nacionalidad=?, Fecha_nacimiento=? WHERE Id_autor=?");
        $stmt->bind_param("sssi", $data['NombreA'], $data['Nacionalidad'], $data['Fecha_nacimiento'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        // Verificar si el autor tiene libros asociados
        $query = $this->db->prepare("SELECT COUNT(*) AS total FROM libros WHERE Id_autor = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result(); 
        $row = $result->fetch_assoc(); 
        $count = $row['total']; 
        $query->close();
    
        if ($count > 0) {
            $_SESSION['error'] = "No se puede eliminar el autor porque está siendo utilizado en la tabla libros.";
            return false; 
        }
    
        // Si no tiene libros, proceder con la eliminación
        $stmt = $this->db->prepare("DELETE FROM autores WHERE Id_autor=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Autor eliminado exitosamente.";
            return true;
        } else {
            $_SESSION['error'] = "Error al eliminar el autor.";
            return false;
        }
    }
}

class UserCrud implements Crud {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (email, nombre, apellidoP, apellidoM, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            die("Error en prepare(): " . $this->db->error);
        }
    
        $stmt->bind_param("ssssss", $data['email'], $data['nombre'], $data['apellidoP'], $data['apellidoM'], $data['password'], $data['role']);
        
        if (!$stmt->execute()) {
            die("Error en execute(): " . $stmt->error);
        }
    
        return true;
    }
    
    

    public function read() {
        $result = $this->db->query("SELECT * FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE users SET  nombre=?, apellidoP=?, apellidoM=?, role=? WHERE Id_user=?");
        $stmt->bind_param("sssss", $data['nombre'], $data['apellidoP'], $data['apellidoM'], $data['role'], $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE Id_user=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

class CrudFactory {
    public static function createCrud($type, $db) {
        switch ($type) {
            case 'libro':
                return new LibroCrud($db);
            case 'autor':
                return new AutorCrud($db);
            case 'user':
                return new UserCrud($db);
            default:
                throw new Exception("Tipo de CRUD no soportado");
        }
    }
}
?>
