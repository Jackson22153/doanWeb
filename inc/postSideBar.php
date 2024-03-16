<!-- parameters: categories searchDes (search destination) -->
<div class="col-lg-4 sidebar-widgets">
    <div class="widget-wrap">
        <!-- search -->
        <div class="single-sidebar-widget search-widget">
            <h4 class="category-title">Search</h4>
            <form class="search-form mt-20" action=<?=$searchDes?>>
                <search-dropdown search-path='search.php' search-condition='{}' des-path='blog-single.php'>
            </form>
        </div>
    <!-- categories -->
        <div class="single-sidebar-widget post-category-widget">
            <h4 class="category-title">Catgories</h4>
            <ul class="cat-list mt-20">
                <?php foreach($categories as $category):?>
                    <li>
                        <a href="category.php?c=<?=$category->category?>" class="d-flex justify-content-between">
                            <p><?=ucfirst($category->category)?></p>
                            <!-- <p>59</p> -->
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>