<!-- <div class="fundoNav p-4 text-center">
    <div class="top">
        <img src="../public/images/image.png" height="200px" width="400px" alt="">
    </div>
</div> -->

<nav class="navbar navbar-expand-sm navbar-dark">
    <div class="container-fluid justify-content-center">
        <ul class="navbar-nav">
            <?php
            if (isset($navLinks) && is_array($navLinks)) {
                foreach ($navLinks as $link) {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . $link['url'] . '">' . $link['label'] . '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </div>
</nav>