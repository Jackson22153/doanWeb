<?php
    class UsersRolesInfo{
        public $id;
        public $username;
        public $role;

        public function __construct($username='') {
            if($username!=''){
                $this->username = $username;
            }
        }


        public function getUserRolesInfo($conn){
            $sql = "
                select * from usersrolesinfo
                where username=:username;
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'UsersRolesInfo');
            $stmt->execute();
            $users = $stmt->fetchAll();

            $result = $users[0];
            $roles = array();
            foreach($users as $user){
                $roles[] = $user->role;
            }
            $result->role = $roles;

            return $result;
        }
        
    }

?>