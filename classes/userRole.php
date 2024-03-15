<?php
    class UserRole{
        public $userID;
        public $roleID;

        public function __construct($userID, $roleID) {
            $this->userID = $userID;
            $this->roleID = $roleID;
        }

        protected function validate(){
            $rs = $this->userID != '' && $this->roleID != '';
            return $rs;
        }


        public function addUserRole($conn){
            if($this->validate()){  
                //Tạo câu lệnh insert chống SQL injection
                $sql = "
                    insert into usersroles(userID, roleID)
                    values(:userID, :roleID);
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':userID', $this->userID, PDO::PARAM_INT);
                $stmt->bindValue(':roleID', $this->roleID, PDO::PARAM_INT);
                return $stmt->execute();
            }else{
                return false;
            }
        }
    }

?>