<?php
    class PostInfo{
        public $id;
        public $postContentID;
        public $postTitle;
        public $postImg;
        public $stateID;
        public $userID;
        public $date;
        public $category;

        public function __construct($postTitle='', $postContentID='', $postImg='', $stateID='', $userID='', $date='', $category='') {
            if($postTitle!='' && $postContentID!='' && $stateID!='' && $userID!='' && $date != '' && $category!= ''){
                $this->postTitle = $postTitle;
                $this->postContentID = $postContentID;
                $this->postImg = $postImg;
                $this->stateID = $stateID;
                $this->userID = $userID;
                $this->date = $date;
                $this->category = $category;
            }
        }

        public static function getPostByID($postID, $conn){
            $sql = "select * from postInfo where id=:postID;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':postID', $postID, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PostInfo'); //Trả về 1 đổi tượng
            $stmt->execute(); // Thực hiện câu lệnh sql
            $postInfo = $stmt->fetchAll(); // Lấy ra cái đối tượng

            $result = $postInfo[0];
            $categories = array();
            foreach($postInfo as $postDetail){
                $categories[] = $postDetail->category;
            }
            $result->category = $categories;

            return $result;
        }

        public static function getPostsByCategories($conn){
            $sql = "select * from postInfo group by category, id;";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PostInfo'); //Trả về 1 đổi tượng
            $stmt->execute(); // Thực hiện câu lệnh sql
            $posts = $stmt->fetchAll(); // Lấy ra cái đối tượng
            return $posts;
        }


        // get posts by category's name
        public static function getPostsByCategory($category, $stateID, $pageNumber, $conn){
            $sql = "
                select * from postInfo 
                where category=:category AND stateID=:stateID
                limit :pageSize offset :pageNumber";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':stateID', $stateID, PDO::PARAM_STR);
            $stmt->bindValue(':category', $category, PDO::PARAM_STR);
            $stmt->bindValue(':pageSize', PAGE_SIZE, PDO::PARAM_INT);
            $stmt->bindValue(':pageNumber', $pageNumber*PAGE_SIZE, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PostInfo'); //Trả về 1 đổi tượng
            $stmt->execute(); // Thực hiện câu lệnh sql
            $posts = $stmt->fetchAll(); // Lấy ra cái đối tượng

            // pageable
            
            $condition = "where category='$category' AND stateID=$stateID";
            $totalPages = Pageable::getTotalPages('postInfo', $condition, $conn);
            $pageable = new Pageable(false, false, $posts, $totalPages, $pageNumber);

            return $pageable;
        }
    }

?>