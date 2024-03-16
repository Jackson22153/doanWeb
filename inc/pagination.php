<!-- parameters: totalPages, pages -->

<nav class="blog-pagination justify-content-center d-flex">
    <ul class="pagination">
        <li class="page-item">
            <a href=<?php
                $url = $_SERVER['REQUEST_URI'];
                $parsed_url = parse_url($url);
                $params = array();
                if (isset($parsed_url['query'])) {
                    parse_str($parsed_url['query'], $params);
                }
                $params['page'] = $page -1>=0?$page-1:0;
                $url = $parsed_url['path'] . '?' . http_build_query($params);
                echo $url;
            ?> class="page-link" aria-label="Previous">
                <span aria-hidden="true">
                    <span class="ti-arrow-left"></span>
                </span>
            </a>
        </li>
        <?php for($i=1; $i<= $totalPages; $i++):?>
            <li class="page-item <?php 
                    if($page+1==$i) echo "active";
                ?>">
                <a href="<?php 
                    $url = $_SERVER['REQUEST_URI'];
                    $parsed_url = parse_url($url);
                    $params = array();
                    if (isset($parsed_url['query'])) {
                        parse_str($parsed_url['query'], $params);
                    }
                    $params['page'] = $i-1;
                    $url = $parsed_url['path'] . '?' . http_build_query($params);
                    echo $url;
                ?>" class="page-link"><?=$i?></a>
            </li>
        <?php endfor;?>

        <li class="page-item">
            <a href=<?php
                $url = $_SERVER['REQUEST_URI'];
                $parsed_url = parse_url($url);
                $params = array();
                if (isset($parsed_url['query'])) {
                    parse_str($parsed_url['query'], $params);
                }
                $params['page'] = $page+1<$totalPages?$page+1:$totalPages-1;
                $url = $parsed_url['path'] . '?' . http_build_query($params);
                echo $url;
            ?> class="page-link" aria-label="Next">
                <span aria-hidden="true">
                    <span class="ti-arrow-right"></span>
                </span>
            </a>
        </li>
    </ul>
</nav>