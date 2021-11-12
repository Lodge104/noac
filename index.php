<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'unitelections-info.php';
require 'vendor/autoload.php';

?>

<!DOCTYPE html>
<html>
<?php

$userInfo = $auth0->getUser();

if (!$userInfo) : ?>

  <head>
    <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
    <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

    <title>NOAC Registration Portal | Occoneechee Lodge - Order of the Arrow, BSA</title>

    <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
    <link rel="stylesheet" href="../style.css">


  </head>

  <?php include "header.php"; ?>

  <body class="d-flex flex-column h-100" id="section-conclave-report-form" data-spy="scroll" data-target="#scroll" data-offset="0">
    <div class="wrapper">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="https://lodge104.net">
          <img src="/assets/lodge-logo.png" alt="Occoneechee Lodge" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse c-navbar-content" id="navbar-main">
          <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="https://lodge104.net" target="_blank">Occoneechee Lodge Home</a>
          </div>
        </div>
      </nav>

      <main class="container-fluid flex-shrink-0">

        <div class="wrapper">

          <main class="container-fluid col-xl-11">
            <?php
            if ($_GET['error'] == 'unauthorized') { ?>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
              <div class="alert alert-danger" role="alert">
                <strong>Error!</strong> You do not have the required role to access the administrator area of the NOAC Registration Portal!
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
              </div>
            <?php } ?>

            <div class="card mb-3">
              <div class="card-body">
                <h3 class="card-title d-inline-flex">Instructions</h3>
                <p>Welcome to the NOAC Application Portal for Occoneechee Lodge. Please enter your BSA ID in the field below to start your application or to check the status of your application.</p>
              </div>
            </div>
            <div class="row gx-5 justify-content-center">
              <div class="card col-md-5">
                <div class="card-body">
                  <form action="/participant/check.php" method="get">
                    <h3 class="form-signin-heading text-center">Applicant and Participant Login</h3>
                    <div class="form-group">
                      <label for="bsaID" class="required">BSA ID</label>
                      <input type="text" id="bsaID" name="bsaID" class="form-control" required>
                    </div>
                    <input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
                  </form>
                </div>
              </div>
              <div class="col-md-1"></div>
              <div class="card col-md-5">
                <div class="card-body">
                  <h3 class="form-signin-heading text-center">Learn More About NOAC</h3>
                  <a role="button" class="btn btn-lg btn-primary btn-block" href="https://lodge104.net/noac">NOAC Information</a>
                  <!-- <h3 class="form-signin-heading text-center">Administrator Login</h3>
                  <a role="button" class="btn btn-lg btn-primary btn-block" href="/login.php">Login</a> -->
                </div>
              </div>
            </div>

        </div>
    </div>
    </div>
    </main>


  <?php else : ?>

    <head>
      <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
      <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

      <title>NOAC Application Portal | Occoneechee Lodge - Order of the Arrow, BSA</title>

      <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
      <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
      <link rel="stylesheet" href="../style.css">


    </head>

    <?php include "header.php"; ?>

    <body class="dashboard d-flex flex-column h-100" id="section-conclave-report-form" data-spy="scroll" data-target="#scroll" data-offset="0">
      <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <a class="navbar-brand" href="https://lodge104.net">
            <img src="/assets/lodge-logo.png" alt="Occoneechee Lodge" class="d-inline-block align-top">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse c-navbar-content" id="navbar-main">
            <div class="navbar-nav ml-auto">
              <a class="nav-item nav-link" href="/admin">Unit List</a>
              <a class="nav-item nav-link" href="https://lodge104.net" target="_blank">Occoneechee Lodge Home</a>
            </div>
          </div>
        </nav>

        <main class="container-fluid col-xl-11">

          <div class="wrapper">

            <?php

            include 'unitelections-info.php';

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            ?>
            <?php
            if ($_GET['status'] == 1) { ?>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
              <div class="alert alert-success" role="alert">
                <strong>Saved!</strong> Your data has been saved! Thanks!
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
              </div>
            <?php } ?>
            <section class="row">
              <div class="col-12">
                <h2>Review NOAC Applications</h2>
              </div>
            </section>

            <?php
            $adultNominationQuery = $conn->prepare("SELECT * from participants");
            $adultNominationQuery->execute();
            $adultNominationQ = $adultNominationQuery->get_result();
            if ($adultNominationQ->num_rows > 0) {
              //print election info

              session_start();
              if (!isset($_SESSION['count'])) {
                $_SESSION['count'] = 0;
              } else {
                $_SESSION['count']++;
              }
            ?>
              <div class="card mb-3">
                <div class="card-body">
                  <h3 class="card-title">Adult Nominations</h3>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Name</th>
                          <th scope="col">BSA ID</th>
                          <th scope="col">Level</th>
                          <th scope="col">Chapter</th>
                          <th scope="col">Review</th>
                          <th scope="col">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($getAdult = $adultNominationQ->fetch_assoc()) {

                        ?><tr>
                            <td><?php echo $getAdult['firstName'] . " " . $getAdult['lastName']; ?></td>
                            <td><?php echo $getAdult['bsa_id']; ?></td>
                            <td><?php echo $getAdult['level']; ?></td>
                            <td><?php echo $getAdult['chapter']; ?></td>
                            <td>
                              <button class="btn btn-primary" role="button" data-toggle="modal" data-target="#Modal-<?php echo $getAdult['bsa_id']; ?>">Review</button>
                              <div class="modal fade" id="Modal-<?php echo $getAdult['bsa_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel"><?php echo $getAdult['firstName'] . " " . $getAdult['lastName']; ?></h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-4">
                                          <div class="list-group" id="list-tab" role="tablist">
                                            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#Personal-<?php echo $getAdult['bsa_id']; ?>" role="tab" aria-controls="home">Personal Information</a>
                                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#Contact-<?php echo $getAdult['bsa_id']; ?>" role="tab" aria-controls="profile">Contact Information</a>
                                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#Scouting-<?php echo $getAdult['bsa_id']; ?>" role="tab" aria-controls="messages">Scouting Information</a>
                                          </div>
                                        </div>
                                        <div class="col-8">
                                          <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="Personal-<?php echo $getAdult['bsa_id']; ?>" role="tabpanel" aria-labelledby="list-home-list"><?php echo $getAdult['address_line1'] . ", " . $getAdult['address_line2']; ?><br><?php echo $getAdult['city'] . ", " . $getAdult['state'] . " " . $getAdult['zip']; ?><br><b>Date of Birth: </b><?php echo $getAdult['dob']; ?><br><b>Gender: </b><?php echo $getAdult['gender']; ?><br><b>T-Shirt Size: </b><?php echo $getAdult['tshirt']; ?></div>
                                            <div class="tab-pane fade" id="Contact-<?php echo $getAdult['bsa_id']; ?>" role="tabpanel" aria-labelledby="list-profile-list"><b>Home Phone: </b><?php echo $getAdult['hphone']; ?><br><b>Cell Phone: </b><?php echo $getAdult['cphone']; ?><br><b>Email Address: </b><?php echo $getAdult['email']; ?></div>
                                            <div class="tab-pane fade" id="Scouting-<?php echo $getAdult['bsa_id']; ?>" role="tabpanel" aria-labelledby="list-messages-list"><b>Chapter: </b><?php echo $getAdult['chapter']; ?><br><b>Level: </b><?php echo $getAdult['level']; ?><br><b>BSA ID: </b><?php echo $getAdult['bsa_id']; ?><br><?php if ($getAdult['aia_check'] == '1') { ?><b>AIA Participation: </b>Yes<br><b>AIA Reasoning: <?php echo $getAdult['aia']; ?></b><?php } ?></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel & Close</button>
                                        <form action="action.php" method="post">
                                          <input id="BSAID" type="hidden" value="<?php echo $getAdult['bsa_id']; ?>">
                                          <input id="Option" type="hidden" value="3">
                                          <input type="submit" class="btn btn-primary" value="Reject">
                                        </form>
                                        <form action="action.php" method="post">
                                          <input id="BSAID" type="hidden" value="<?php echo $getAdult['bsa_id']; ?>">
                                          <input id="Option" type="hidden" value="2">
                                          <input type="button" class="btn btn-primary" value="Waitlist">
                                        </form>
                                        <form action="action.php" method="post">
                                          <input id="BSAID" type="hidden" value="<?php echo $getAdult['bsa_id']; ?>">
                                          <input id="Option" type="hidden" value="1">
                                          <input type="submit" class="btn btn-primary" value="Approve">
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            <td><?php
                                if ($getAdult['status'] == '0') { ?>
                                <span class="badge badge-warning">Awaiting Review</span>
                              <?php } elseif ($getAdult['status'] == '1') { ?>
                                <span class="badge badge-success">Approved</span>
                              <?php } elseif ($getAdult['leader_signature'] == '2') { ?>
                                <span class="badge badge-danger">Waitlisted</span>
                              <?php } elseif ($getAdult['leader_signature'] == '3') { ?>
                                <span class="badge badge-danger">Rejected</span>
                              <?php } ?>
                            </td>
                          </tr>
                      <?php }
                      } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
      </div>
      </main>
    <?php endif ?>


    <?php include "footer.php"; ?>

    <script src="../libraries/jquery-3.4.1.min.js"></script>
    <script src="../libraries/popper-1.16.0.min.js"></script>
    <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <script src="https://elections.lodge104.net/login/js/login.js"></script>
    </body>

</html>