<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../unitelections-info.php';

$host = $_SERVER['SERVER_NAME'];
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
  <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

  <title>NOAC Participant Dashboard | Occoneechee Lodge - Order of the Arrow, BSA</title>

  <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
  <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
  <link rel="stylesheet" href="../style.css">

</head>

<?php include "../header.php"; ?>

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
      <?php
      if ($_GET['status'] == 1) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-success" role="alert">
          <strong>Loaded!</strong> Your payment data is up to date!
          <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      <?php } ?>
      <?php
      if ($_GET['status'] == 2) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-success" role="alert">
          <strong>Saved!</strong> Your application has been submitted. Please see below for additional instructions.
          <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      <?php } ?>
      <?php
      if ($_GET['status'] == 3) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-danger" role="alert">
          <strong>Warning!</strong> Your application was canceled and no data was saved.
          <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      <?php } ?>
      <?php
      if ($_GET['status'] == 4) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-danger" role="alert">
          <strong>Oh No!</strong> We can't find you BSA ID! Try again!
          <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      <?php } ?>
      <?php
      include '../unitelections-info.php';
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      if (isset($_GET['bsaID'])) {
        $bsaID = $_POST['bsaID'] = $_GET['bsaID'];

        $json = $_SESSION['transactions'];
        $transactions = $json['transactions'];
        $sku = array_column($transactions, 'sku');

        $getParticipantsQuery = $conn->prepare("SELECT * from participants where bsa_id = ?");
        $getParticipantsQuery->bind_param("s", $bsaID);
        $getParticipantsQuery->execute();
        $getParticipantsQ = $getParticipantsQuery->get_result();
        if ($getParticipantsQ->num_rows > 0) {
          //print election info
          $getParticipants = $getParticipantsQ->fetch_assoc();
      ?>
          <!-- Horizontal Steppers -->
          <div class="row">
            <div class="col-md-12">
              <!-- Stepers Wrapper -->
              <ul class="stepper stepper-horizontal">
                <!-- First Step -->
                <li class="completed">
                  <a>
                    <span style="background-color: #4caf50 !important;" class="circle">1</span>
                    <span class="label">Application Submitted</span>
                  </a>
                </li>
                <?php
                if ((!in_array("22Y-NOAC Deposit", $sku)) and (!in_array("22A-NOAC Deposit", $sku))) {
                ?>
                  <li class="warning active">
                    <a>
                      <span class="circle">2</span>
                      <span class="label">Deposit Needed</span>
                    </a>
                  </li>
                <?php }
                if ((in_array("22Y-NOAC Deposit", $sku)) || (in_array("22A-NOAC Deposit", $sku))) { ?>
                  <li class="completed">
                    <a>
                      <span style="background-color: #4caf50 !important;" class="circle">2</span>
                      <span class="label">Deposit Completed</span>
                    </a>
                  </li>
                <?php } ?>
                <?php
                if ($getParticipants['status'] == '0') {
                ?>
                  <li class="">
                    <a>
                      <span class="circle">3</span>
                      <span class="label">Application Approval</span>
                    </a>
                  </li>
                <?php }
                if ($getParticipants['status'] == '1') { ?>
                  <li class="completed">
                    <a>
                      <span class="circle">3</span>
                      <span class="label">Application Approved</span>
                    </a>
                  </li>
                  <?php if ($getParticipants['payment'] == '1') { ?>
                    <?php if ((!in_array("NOAC Paid-in-Full-Y", $sku)) and (!in_array("NOAC Paid-in-Full", $sku))) { ?>
                      <li class="warning active">
                        <a>
                          <span class="circle">4</span>
                          <span class="label">Final Payment Needed by 12/7/2021</span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <li class="completed">
                        <a>
                          <span class="circle">4</span>
                          <span class="label">Final Payment Completed</span>
                        </a>
                      </li>
                    <?php }
                  } else { ?>
                    <?php if ((!in_array("22Y-NOAC Payment 1", $sku)) and (!in_array("22A-NOAC Payment 1", $sku))) { ?>
                      <li class="warning active">
                        <a>
                          <span class="circle">4</span>
                          <span class="label">Payment 1 Needed by 1/20/2022</span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <li class="completed">
                        <a>
                          <span class="circle">4</span>
                          <span class="label">Payment 1 Completed</span>
                        </a>
                      </li>
                    <?php } ?>
                    <?php if ((!in_array("22Y-NOAC Payment 2", $sku)) and (!in_array("22A-NOAC Payment 2", $sku))) { ?>
                      <li class="warning active">
                        <a>
                          <span class="circle">5</span>
                          <span class="label">Payment 2 Needed by 2/20/2022</span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <li class="completed">
                        <a>
                          <span class="circle">5</span>
                          <span class="label">Payment 2 Completed</span>
                        </a>
                      </li>
                    <?php } ?>
                    <?php
                    //explode the date to get month, day and year
                    $birthDate = explode("-", $getParticipants['dob']);
                    //get age from date or birthdate
                    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                      ? ((date("Y") - $birthDate[2]) - 1)
                      : (date("Y") - $birthDate[2]));

                    if (($age >= '21') and (!in_array("22A-NOAC Payment 3", $sku))) { ?>
                      <li class="warning active">
                        <a>
                          <span class="circle">6</span>
                          <span class="label">Payment 3 Needed by 3/20/2022</span>
                        </a>
                      </li>
                    <?php } elseif (($age >= '21') and (in_array("22A-NOAC Payment 3", $sku))) { ?>
                      <li class="completed">
                        <a>
                          <span class="circle">5</span>
                          <span class="label">Payment 3 Completed</span>
                        </a>
                      </li>
                    <?php } ?>
                  <?php }
                }
                if ($getParticipants['status'] == '2') { ?>
                  <li class="warning active">
                    <a>
                      <span class="circle">3</span>
                      <span class="label">Waitlisted</span>
                    </a>
                  </li>
                  <li class="step">
                    <a>
                      <span class="circle">4</span>
                      <span class="label">Application Approved</span>
                    </a>
                  </li>
                <?php } ?>
              </ul>
              <!-- /.Stepers Wrapper -->
            </div>
          </div>
          <!-- /.Horizontal Steppers -->
          <section class="row">
            <div class="col-12">
              <a href="refresh.php?bsaID=<?php echo $bsaID ?>" class="btn btn-sm btn-secondary mb-2 d-inline-flex float-right">Refresh Payment Status</a>
              <h2>NOAC Participant Dashboard</h2>
            </div>
          </section>
          <div class="card mb-3">
            <div class="card-body">
              <h3 class="card-title d-inline-flex">What comes next?</h3>

              <?php
              if ($getParticipants['status'] == '0') {
                if ((!in_array('22Y-NOAC Deposit', $sku)) and (!in_array('22A-NOAC Deposit', $sku))) {
              ?>
                  <p>Your application to be a part of the Lodge's NOAC contingent has been submitted. Your next step is to pay the deposit using the button below. Once your deposit has been successfully submitted, your application will be reviewed by the contingent leadership. You will not be considered apart of contingent until your depsit has been paid and your application has been approved.</p>
                  <h3 class="card-title d-inline-flex">Pay your Deposit</h3>
                  <a target="_blank" href="https://registration.lodge104.net/MemberRegistration/Select/<?php echo $getParticipants['oalm_id'] ?>">
                    <button type="button" class="btn btn-primary">Pay</button>
                  </a>
                <?php
                } else {
                ?>
                  <p>Your application to be a part of the Lodge's NOAC contingent has been submitted and your deposit has been paid! Your application will be reviewed by the contingent leadership before you are officially apart of the contingent. <?php if ($getParticipants['payment'] == '1') { ?> You selected payment schedule option 1 to pay your NOAC fees in full by December 7th. Once you're notified your application is approved, check back for more instructions on finishing your payment. <?php } else { ?> You selected payment schedule option 2 to pay your NOAC fees in equal payments. Once you're notified your application is approved, check back for more instructions on finishing your payments.<?php } ?> </p>
                <?php }
              } if ($getParticipants['status'] == '1') {
                if ($getParticipants['payment'] == '1' and ((!in_array('NOAC Paid-in-Full-Y', $sku)) and (!in_array('NOAC Paid-in-Full', $sku)))) { ?>
                  <p>Your application to be a part of the Lodge's NOAC contingent has been approved and your deposit has been paid! You selected payment schedule option 1 to pay your NOAC fees in full by December 7th. Your next step is to pay this fee using the button below.</p>
                  <a target="_blank" href="https://registration.lodge104.net/MemberRegistration/Select/<?php echo $getParticipants['oalm_id'] ?>">
                    <button type="button" class="btn btn-primary">Pay</button>
                  </a>
                <?php } elseif ($getParticipants['payment'] == '1') { ?>
                  <p>Your application to be a part of the Lodge's NOAC contingent has been approved and you're all paid up! Congrats! Sit tight and wait for more information from contingent leadership.</p>
                <?php } ?>
                <?php if ($getParticipants['payment'] == '2' and ((!in_array('22Y-NOAC Payment 2', $sku)) and (!in_array('22A-NOAC Payment 3', $sku)))) { ?>
                  <p>Your application to be a part of the Lodge's NOAC contingent has been approved and your deposit has been paid! You selected payment schedule option 2 to pay your NOAC fees in scheduled payments. Your next step is to pay these fees using the button below starting December 8th.</p>
                  <?php if (strtotime('12-08-2021') >= strtotime('now')) { ?>
                    <a target="_blank" href="https://registration.lodge104.net/MemberRegistration/Select/<?php echo $getParticipants['oalm_id'] ?>">
                      <button type="button" class="btn btn-primary">Pay</button>
                    </a>
                  <?php } else { ?>
                    <div class="alert alert-danger" role="alert">
                      Payment plan available after December 7th.
                    </div>
                  <?php } ?>
                <?php } elseif ($getParticipants['payment'] == '2') { ?>
                  <p>Your application to be a part of the Lodge's NOAC contingent has been approved and you're all paid up! Congrats! Sit tight and wait for more information from contingent leadership.</p>
                <?php } ?>
              <?php } ?>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-body">
              <h3 class="card-title d-inline-flex">Your Information</h3>
              <div class="row">
                <div class="col-md-3">
                  <?php echo $getParticipants['firstName']; ?> <?php echo $getParticipants['lastName'] ?><br>
                </div>
                <div class="col-md-3">
                  <?php echo $getParticipants['address_line1']; ?><br>
                  <?php echo ($getParticipants['address_line2'] == "" ? '' : $getParticipants['address_line2'] . "<br>"); ?>
                  <?php echo $getParticipants['city']; ?>, <?php echo $getParticipants['state']; ?> <?php echo $getParticipants['zip']; ?><br>
                </div>
                <div class="col-md-3">
                  <?php echo $getParticipants['sm_email']; ?><br>
                  <?php echo $getParticipants['sm_phone']; ?><br>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">BSA ID</th>
                      <th scope="col">Date of Birth</th>
                      <th scope="col">Gender</th>
                      <th scope="col">Chapter</th>
                      <th scope="col">T-Shirt Size</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $getParticipants['bsa_id']; ?></td>
                      <td><?php echo $getParticipants['dob']; ?></td>
                      <td><?php echo $getParticipants['gender']; ?></td>
                      <td><?php echo $getParticipants['chapter']; ?></td>
                      <td><?php echo $getParticipants['tshirt']; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php
        } else {
          header("Location: participant/check.php?bsaID=" . $bsaID);
        ?>
        <?php
        }
      } else {
        //no accessKey
        ?>
        <div class="card col-sm">
          <div class="card-body">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
              <h3 class="card-title">BSA ID </h3>
              <form action='/participant/check.php' method="get">
                <div class="form-group">
                  <label for="bsaID" class="required">BSA ID</label>
                  <input type="text" id="bsaID" name="bsaID" class="form-control" autocomplete="off" required>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
              </form>
              <div class="col-sm-4"></div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>

    </main>
  </div>
  <?php include "../footer.php"; ?>

  <script src="../libraries/jquery-3.4.1.min.js"></script>
  <script src="../libraries/popper-1.16.0.min.js"></script>
  <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

  <script>
    var clipboard = new ClipboardJS('.btn');

    clipboard.on('success', function(e) {
      console.log(e);
    });

    clipboard.on('error', function(e) {
      console.log(e);
    });
  </script>

</body>

</html>