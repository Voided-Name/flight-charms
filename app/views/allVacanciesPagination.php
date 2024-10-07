<?php

if ($_SESSION['paginationNum'] == 0) {
  $prevState = false;
} else {
  $prevState = true;
}

?>


<form method="GET" action="vacancies.php">
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
      <li class="page-item">
        <?php if ($prevState) {
        ?>
          <button type="submit" class="page-link" href="#" name="page" value="previous">Previous</a>
          <?php
        } else {
          ?>
            <button type="submit" class="page-link bg-light" href="#" name="page" value="previous" disabled>Previous</a>
            <?php
          }
            ?>
      </li>
      <li class="page-item">
        <?php if ($nextState) {
        ?>
          <button type="submit" name="page" class="page-link" value="next">Next</button>
        <?php
        } else {
        ?>
          <button type="submit" name="page" class="page-link bg-light" value="next" disabled>Next</button>
        <?php
        }
        ?>
      </li>
    </ul>
  </nav>
</form>
