<?php
?>
    <div class="col-2 bg-light">
        <nav class="navbar-light">
            <ul class="nav navbar-nav flex-column">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" 
                       id="dropdown_products"  
                       data-toggle="dropdown" 
                       aria-haspopup="true" 
                       aria-expanded="false">Produkter</a>
                        <ul class="dropdown-menu" 
                            aria-labelledby="dropdown_products">
                            <li class="dropdown-item">
                                <a href="<?php echo ROOT?>/admin/produkt/list" class="dropdown-item">Liste</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="<?php echo ROOT?>/admin/produkt/create" class="dropdown-item">Opret</a>
                            </li>
                        </ul>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link dropdown-toggle"
                       id="dropdown_users"  
                       data-toggle="dropdown" 
                       aria-haspopup="true" 
                       aria-expanded="false">Brugere</a>
                    <ul class="dropdown-menu" 
                            aria-labelledby="dropdown_users">
                            <li class="dropdown-item">
                                <a href="<?php echo ROOT?>/admin/brugere/list" class="dropdown-item">Liste</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="<?php echo ROOT?>/admin/brugere/create" class="dropdown-item">Opret</a>
                            </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">abc</a>
                </li>
            </ul>

        </nav>
    </div>
