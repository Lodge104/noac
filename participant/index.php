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
                if (!in_array("22NOAC Deposit", $sku)) {
                ?>
                  <li class="warning active">
                    <a>
                      <span class="circle">2</span>
                      <span class="label">Deposit Needed</span>
                    </a>
                  </li>
                <?php }
                if (in_array("22NOAC Deposit", $sku)) { ?>
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
                <?php }
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
              if (!in_array('22NOAC Deposit', $sku)) {
              ?>
                <p>Your application to be a part of the Lodge's NOAC contingent has been submitted. Your next step is to pay the deposit using the button below. Once your deposit has been successfully submitted, your application will be reviewed by the contingent leadership. You will not be considered apart of contingent until your depsit has been paid and your application has been approved.</p>
                <h3 class="card-title d-inline-flex">Pay your Deposit</h3>
                <a target="_blank" href="https://registration.lodge104.net/MemberRegistration/Select/<?php echo $getParticipants['oalm_id'] ?>">
                  <button type="button" class="btn btn-primary">Pay</button>
                </a>
              <?php } ?>
              <?php
              if (in_array('22NOAC Deposit', $sku)) {
              ?>
                <p>Your application to be a part of the Lodge's NOAC contingent has been submitted and your deposit has been paid! Your application will be reviewed by the contingent leadership before you are officially apart of the contingent. <?php if ($getParticipants['payment'] == '1') {?> You selected payment schedule option 1 to pay your NOAC fees in full by December 7th. Once you're notified your application is approved, check back for more instructions on finishing your payment. <?php } else {?> You selected payment schedule option 2 to pay your NOAC fees in equal payments. Once you're notified your application is approved, check back for more instructions on finishing your payments.<?php } ?> </p>
                </a>
              <?php } ?>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-body">
              <h3 class="card-title d-inline-flex">Your Information</h3>
              <div class="row">
                <div class="col-md-3">
                <?php echo $getParticipants['firstName']; ?> <?php echo $getParticipants['lastName']?><br>
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