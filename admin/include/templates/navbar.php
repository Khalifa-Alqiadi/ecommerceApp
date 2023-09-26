<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME'); ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link "  href="categories.php"><?php echo lang('CATEGORISE'); ?></a></li>
        <li class="nav-item"><a class="nav-link "  href="items.php"><?php echo lang('ITEMS'); ?></a></li>
        <li class="nav-item"><a class="nav-link "  href="members.php"><?php echo lang('MEMBERS'); ?></a></li>
        <li class="nav-item"><a class="nav-link "  href="comments.php"><?php echo lang('COMMENTS'); ?></a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo $_SESSION['UserName'] ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">
                   <?php echo lang('EDIT_PROFILE'); ?>
                </a>
            </li>
            <li><a class="dropdown-item" href="#"><?php echo lang('SETTINGS'); ?></a></li>
            <li><a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT'); ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>