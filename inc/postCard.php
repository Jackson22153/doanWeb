<!-- parameters: $post, $postHref-->
<?php
    if(!isset($postHref)){
        $postHref = 'blog-single.php';
    }

    $postInfo = PostInfo::getPostByID($post->id, $conn);
    $categoriesOfPost = $postInfo->category;
?>
<div class="single-amenities">
    <a href=<?=$postHref.'?p='.$post->id?>>
        <div class="amenities-thumb">
            <img
                class="img-fluid w-100"
                src=<?php
                    $img = $post->postImg;
                    $img = $img!=null? $img: 'img/blog-post/defaultImage.png';
                    echo $img;
                ?>
                alt=""
            />
        </div>
        <div class="amenities-details">
            <h5>
                <?= $post->postTitle?>
            </h5>
            <div class="amenities-meta mb-10">
                <a class="">
                    <span class="ti-calendar"></span><?=$post->date?>
                </a>
            </div>
            <!-- <p>
            Creepeth green light appear let rule only you're divide
            and lights moving and isn't given creeping deep.
            </p> -->
    
            <div class="d-flex justify-content-between mt-20">
                <div>
                    <a class="blog-post-btn">
                    Read More <span class="ti-arrow-right"></span>
                    </a>
                </div>
                <div class="category">
                    <a>
                        <span class="ti-folder mr-1"></span> <?php
                            $postCategories = '';
                            foreach($categoriesOfPost as $category){
                                $postCategories = $postCategories. $category.', ';
                            }
                            $postCategories = substr($postCategories, 0, strlen($postCategories)-2);
                            echo $postCategories;
                        ?>
                    </a>
                </div>
            </div>
        </div>
    </a>
</div>