<?php
    class Role{
        public $id;
        public $role;

        public function __construct($role=null) {
            if($role!=null){
                $this->role = $role;
            }
        }

        public static function getRole($roleName, $conn){
            $sql = "
                select * from roles
                where role=:role;
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':role', $roleName, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Role');
            $stmt->execute();
            $role = $stmt->fetch();

            return $role;
        }

        public static function getAllRoles($conn){
            $sql = "
                select * from roles
            ";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Role');
            $stmt->execute();
            $role = $stmt->fetchAll();

            return $role;
        }

        
    }
?>