<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">HomePage</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav  me-auto mb-2 mb-lg-0">
        <?php
          $cats = getAllTable('*', 'categories', 'where Parent = 0', '', 'ID', 'ASC');
            foreach($cats as $cat){
              echo "<li><a class='nav-link' href='categories.php?catid=" . $cat['ID'] . "'>" . $cat['Name'] ."</a></li>";
            }
        ?>
      </ul>
    </div>
  </div>
</nav>