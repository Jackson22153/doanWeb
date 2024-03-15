<?php
    class UserRole{
        public $userID;
        public $roleID;

        public function __construct($userID, $roleID) {
            $this->userID = $userID;
            $this->roleID = $roleID;
        }
        public function addUserRole($conn){
            $sql = "INSERT INTO usersroles (userID, roleID) VALUES (:userID, :roleID)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':userID', $this->userID, PDO::PARAM_INT);
            $stmt->bindValue(':roleID', $this->roleID, PDO::PARAM_INT);
            return $stmt->execute();
        }
        
    }

?>