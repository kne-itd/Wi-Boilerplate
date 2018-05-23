<?php
?>
<nav  class="navbar navbar-expand-sm navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo ROOT ?>/home"><?php echo PROJECT_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT ?>/home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT ?>/contact">Kontakt</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT ?>/about">About</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo ROOT ?>/signin/signout">Log ud</a></li>

        </ul>
<?php
if ($search_bar) {
?>
        <form class="form-inline my-2 my-lg-0" action="<?php echo ROOT . '/'. $page ?>/search" method="get">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Søg</button>
<?php
}
?>
    </div>
        
</nav>