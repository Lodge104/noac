<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../unitelections-info.php';

$host = $_SERVER['SERVER_NAME'];
$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'usd',
      'product_data' => [
        'name' => 'NOAC Deposit',
      ],
      'unit_amount' => 10000,
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'cancel_url' => 'https://lodge104-noac-staging.herokuapp.com/participant/index.php?status=3',
]);
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
  <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

  <title>Unit Leader's Dashboard | Occoneechee Lodge - Order of the Arrow, BSA</title>

  <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
  <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
  <link rel="stylesheet" href="../style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
  <script src="https://js.stripe.com/v3/"></script>

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
          <strong>Saved!</strong> Your data has been saved! Thanks!
          <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      <?php } ?>
      <?php
      if ($_GET['status'] == 2) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-success" role="alert">
          <strong>Saved!</strong> Your adult nomination has been saved. Your Unit Chair has been emailed an invite to review and approve of the nomination. Your nomination will not be reviewed by the selection committee until this first step happens.
          <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      <?php } ?>
      <?php
      if ($_GET['status'] == 3) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-danger" role="alert">
          <strong>Warning!</strong> Your adult nomination was canceled and no data was saved.
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
                if ($getParticipants['deposit'] == '0') {
                ?>
                  <li class="warning active">
                    <a>
                      <span class="circle">2</span>
                      <span class="label">Deposit Needed</span>
                    </a>
                  </li>
                <?php }
                if ($getParticipants['deposit'] == '1') { ?>
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
              <h2>NOAC Participant Dashboard</h2>
            </div>
          </section>
          <div class="card mb-3">
            <div class="card-body">
              <h3 class="card-title d-inline-flex">What comes next?</h3>
              <?php
              if ($getParticipants['deposit'] == '0') {
              ?>
                <p>Your application to be a part of the Lodge's NOAC contingent has been submitted. Your next step is to pay the deposit using the button below. Once your deposit has been successfully submitted, your application will be reviewed by the contingent leadership.</p>
                <h3 class="card-title d-inline-flex">Pay your Deposit</h3>
                <?php
                ?>
                <button id="deposit">Pay Deposit</button>
                <script>
                  var stripe = Stripe('<?php echo getenv('STRIPEPKEY') ?>');
                  const btn = document.getElementById("deposit")
                  btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    stripe.redirectToCheckout({
                      sessionId: "<?php echo $session->id; ?>"
                    },{
                      receipt_email: "<?php echo $getParticipants['email']; ?>"
                    },{
                      successUrl: "<?php echo $host . '/participants/create-deposit.php?bsaID=' . $getParticipants['bsa_id']?>"
                    });
                  });
                </script>
              <?php } ?>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-body">
              <a href="edit-unit-election.php?accessKey=<?php echo $accessKey; ?>" class="btn btn-sm btn-secondary mb-2 d-inline-flex float-right">edit</a>
              <h3 class="card-title d-inline-flex">Unit Information</h3>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Unit Type</th>
                      <th scope="col">Unit Number</th>
                      <th scope="col"># of Youth Elected</th>
                      <th scope="col">Chapter</th>
                      <th scope="col">Date of Election</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $getUnitElections['unitCommunity']; ?></td>
                      <td><?php echo $getUnitElections['unitNumber']; ?></td>
                      <td><?php echo $getUnitElections['numRegisteredYouth']; ?></td>
                      <td><?php echo $getUnitElections['chapter']; ?></td>
                      <td><?php echo date("m-d-Y", strtotime($getUnitElections['dateOfElection'])); ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <h5 class="card-title">Unit Leader Information</h5>
              <div class="row">
                <div class="col-md-3">
                  <?php echo $getUnitElections['sm_name']; ?><br>
                </div>
                <div class="col-md-3">
                  <?php echo $getUnitElections['sm_address_line1']; ?><br>
                  <?php echo ($getUnitElections['sm_address_line2'] == "" ? '' : $getUnitElections['sm_address_line2'] . "<br>"); ?>
                  <?php echo $getUnitElections['sm_city']; ?>, <?php echo $getUnitElections['sm_state']; ?> <?php echo $getUnitElections['sm_zip']; ?><br>
                </div>
                <div class="col-md-3">
                  <?php echo $getUnitElections['sm_email']; ?><br>
                  <?php echo $getUnitElections['sm_phone']; ?><br>
                </div>
              </div>
            </div>
          </div>

          <?php

          $rawadults = ($getUnitElections['numRegisteredYouth'] * (2 / 3));
          $numadults = ceil($rawadults);

          $tz = 'America/New_York';
          $timestamp = time();
          $dt = new DateTime("now", new DateTimeZone($tz));
          $dt->setTimestamp($timestamp);

          $date = $dt->format("Y-m-d");
          $hour = $dt->format("H");
          if ((strtotime($getUnitElections['dateOfElection']) < strtotime($date)) || ($getUnitElections['dateOfElection'] == $date && $hour >= 21)) { ?>
            <?php
            $adultNominationQuery = $conn->prepare("SELECT * from adultNominations where unitId = ?");
            $adultNominationQuery->bind_param("s", $getUnitElections['id']);
            $adultNominationQuery->execute();
            $adultNominationQ = $adultNominationQuery->get_result();
            if ($adultNominationQ->num_rows > 0) {
              //print election info
            ?>
              <!--<div class="collapse" id="online">-->
              <div class="card mb-3">
                <div class="card-body">
                  <h3 class="card-title">Adult Nominations</h3>
                  <div class="row">
                    <?php
                    if ($adultNominationQ->num_rows < $numadults) { ?>
                      <div class="col-auto">
                        <a href="../unitleader/add-nomination.php?accessKey=<?php echo $getUnitElections['accessKey']; ?>" class="btn btn-primary" role="button">Submit a New Adult Nomination</a>
                      </div>
                    <?php } else { ?>
                      <div class="col-auto">
                        <div class="alert alert-danger" role="alert">
                          All out of nominations!
                        </div>
                      </div>
                    <?php } ?>
                  </div><br>
                  <div class="alert alert-primary" role="alert">
                    <b>Your unit is allowed <?php echo ($numadults) ?> adult nominations.</b><br>The number of adults nominated can be no more than two-third of the number of youth candidates elected, rounded up where the number of youth candidates is not a multiple of three. In addition to the two-third limit, the unit committee may nominate the currently-serving unit leader (but not assistant leaders), as long as he or she has served as unit leader for at least the previous 12 months.
                  </div><br>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Name</th>
                          <th scope="col">BSA ID</th>
                          <th scope="col">Position</th>
                          <th scope="col">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($getAdult = $adultNominationQ->fetch_assoc()) {
                        ?><tr>
                            <td><?php echo $getAdult['firstName'] . " " . $getAdult['lastName']; ?></td>
                            <td><?php echo $getAdult['bsa_id']; ?></td>
                            <td><?php echo $getAdult['position']; ?></td>
                            <td>
                              <?php
                              if (($getAdult['leader_signature'] == '1' && (($getAdult['chair_signature'] == '1') && ($getAdult['advisor_signature'] == '2')))) { ?>
                                <span class="badge badge-warning">Not Approved by Selection Committee</span>
                              <?php } elseif (($getAdult['leader_signature'] == '1' && (($getAdult['chair_signature'] == '1') && ($getAdult['advisor_signature'] == '1')))) { ?>
                                <span class="badge badge-success">Approved by Selection Committee</span>
                              <?php } elseif (($getAdult['leader_signature'] == '1' && $getAdult['chair_signature'] == '1')) { ?>
                                <span class="badge badge-danger">Waiting for Selection Committee</span>
                              <?php } elseif (($getAdult['leader_signature'] == '1')) { ?>
                                <span class="badge badge-danger">Waiting for Unit Chair Approval</span>
                              <?php } ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--</div>-->
            <?php
            } else {
            ?>
              <div class="card mb-3">
                <div class="card-body">
                  <h3 class="card-title">Adult Nominations</h3>
                  <div class="row">
                    <div class="col-auto">
                      <a href="../unitleader/add-nomination.php?accessKey=<?php echo $getUnitElections['accessKey']; ?>" class="btn btn-primary" role="button">Submit a New Adult Nomination</a>
                    </div>
                  </div><br>
                  <div class="alert alert-danger" role="alert">
                    <b>There are no adult nominations yet. Your unit is allowed <?php echo ($numadults) ?> adult nominations.</b><br>Each year, upon holding a troop or team election for youth candidates that results in at least one youth candidate being elected, the unit committee may nominate registered unit adults (age 21 or over) to the lodge adult selection committee. The number of adults nominated can be no more than two-third of the number of youth candidates elected, rounded up where the number of youth candidates is not a multiple of three. In addition to the two-third limit, the unit committee may nominate the currently-serving unit leader (but not assistant leaders), as long as he or she has served as unit leader for at least the previous 12 months.
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          <?php } else { ?>
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="card-title">Adult Nominations</h3>
                <div class="alert alert-danger" role="alert">
                  Adult nominations are not available until 9:00 pm EST on the day of the election. Each year, upon holding a troop or team election for youth candidates that results in at least one youth candidate being elected, the unit committee may nominate registered unit adults (age 21 or over) to the lodge adult selection committee. The number of adults nominated can be no more than two-third of the number of youth candidates elected, rounded up where the number of youth candidates is not a multiple of three. In addition to the two-third limit, the unit committee may nominate the currently-serving unit leader (but not assistant leaders), as long as he or she has served as unit leader for at least the previous 12 months. To prepare your nominations in advance, please see this <a href='https://lodge104.net/download/5525/' target="_blank">PDF with the exact same questions</a>.
                </div>
              </div>
            </div>
          <?php } ?>


        <?php
        } else {
        ?>
          <div class="alert alert-danger" role="alert">
            There are no elections in the database.
          </div>
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
              <form action='' method="get">
                <div class="form-group">
                  <label for="accessKey" class="required">BSA ID</label>
                  <input type="text" id="accessKey" name="accessKey" class="form-control" autocomplete="off" required>
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