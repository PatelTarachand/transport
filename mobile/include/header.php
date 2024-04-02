<div class="navbar-fixed ">
    <nav class="green darken-3">
        <div class="nav-wrapper">
            <?php if ($pagename == "dashboard.php") { ?>
                <a href="#!"  data-target="slide-out" class="sidenav-trigger" style="display: block;">
                    <i class="material-icons white-text">menu</i>
                </a>
                <div class="brand-logo">
                SHIVALI LOGISTICS
                </div>
            <?php  } else { ?>
                <a href="#!" onclick="history.back()" class="sidenav-trigger" style="display: block;">
                    <i class="material-icons white-text">arrow_back</i>
                </a>
                <div class="brand-logo white-text">
                    <?php echo $title; ?>
                </div>
            <?php } ?>
        </div>
    </nav>
</div>