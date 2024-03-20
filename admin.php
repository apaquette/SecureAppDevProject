<?php
      include_once 'header.php';
      include_once 'includes/dbh.inc.php';

      //Validation here to prevent normal user from accessing directly
      if (!isset($_SESSION['u_id']) || $_SESSION['u_admin'] == 0) {
            header("Location: index.php");
      } else {
            $user_id = $_SESSION['u_id'];
            $user_uid = $_SESSION['u_uid'];
      }
?>

      <section class="main-container">
            <div class="main-wrapper">
                  <h2>Login Events</h2>
                  <div class="admin-entry-count">
                        <?php
                              $stmt = $conn->prepare("SELECT count(event_id) AS num_rows FROM loginevents");
                              $stmt->execute();
                              $total = $stmt->fetch()[0];
                        ?>
                        <p><i>Total entry count: <?php echo $total; ?></i></p>
                  </div>
                  <?php
                        $stmt = $conn->prepare("SELECT * FROM loginevents");
                        $stmt->execute();
                        
                        while ($row = $stmt->fetch()) {
                              $id = $row['event_id'];
                              $ipAddr = $row['ip'];
                              $time = $row['timeStamp'];
                              $user_id = $row['user_id'];
                              $outcome = $row['outcome'];

                              echo "<div class='admin-content'>
                                          Entry ID: <b>$id</b>
                                          <br>
                                          <form class='admin-form' method='GET'>
                                                <label>IP Address: </label><input type='text' name='IP' value='$ipAddr' ><br>
                                                <label>Timestamp: </label><input type='text' name='timestamp' value='$time' ><br>
                                                <label>User ID: </label><input type='text' name='timestamp' value='$user_id' ><br>
                                                <label>Outcome: </label><input type='text' name='timestamp' value='$outcome' >
                                          </form>
                                          <br>
                                    </div>";
                        }
                  ?>
            </div>
      </section>
      <?php
            include_once 'footer.php';
      ?>
