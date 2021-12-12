<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../unitelections-info.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$json = $_SESSION['jsonData'];

?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
  <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

  <title>Add NOAC Application | Occoneechee Lodge - Order of the Arrow, BSA</title>

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
      if (isset($_GET['bsaID'])) {
        $bsaID = $_POST['bsaID'] = $_GET['bsaID'];
      ?>
        <div class="card mb-3">
          <div class="card-body">
            <h1 class="card-title">2022 National Order of the Arrow Conference Application</h1>
            <div class="form-row">
              <div class="col-md-12">
                <h3 class="required">Personal Information</h3>
              </div>
            </div>
            <form action="add-application-process.php" method="post">
              <div class="form-row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="hidden" id="oalm_id" name="oalm_id" value="<?php echo $json['oalmID']; ?>">
                    <input id="firstName" name="firstName" type="text" class="form-control" value="<?php echo $json['firstName']; ?>" disabled>
                    <input id="firstName" name="firstName" type="hidden" class="form-control" value="<?php echo $json['firstName']; ?>">
                  </div>
                  <div class="form-group">
                    <input id="lastName" name="lastName" type="text" class="form-control" placeholder="Last Name" value="<?php echo $json['lastName']; ?>" disabled>
                    <input id="lastName" name="lastName" type="hidden" class="form-control" placeholder="Last Name" value="<?php echo $json['lastName']; ?>">
                  </div>
                  <div class="form-group">
                    <select id="tshirt" name="tshirt" type="custom-select" class="form-control" required>
                      <option value="" disabled selected>Adult T-Shirt Size</option>
                      <option value="Small">Small</option>
                      <option value="Medium">Medium</option>
                      <option value="Large">Large</option>
                      <option value="X-Large">X-Large</option>
                      <option value="XX-Large">XX-Large</option>
                      <option value="XXX-Large">XXX-Large</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="address_line1" name="address_line1" type="text" class="form-control" placeholder="Address" required>
                  </div>
                  <div class="form-group">
                    <input id="address_line2" name="address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)">
                  </div>
                  <div class="form-group">
                    <select id="gender" name="gender" type="custom-select" class="form-control" placeholder="Gender" required>
                      <option value="" disabled selected>Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="city" name="city" type="text" class="form-control" placeholder="City" required>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <input id="state" name="state" type="text" class="form-control" placeholder="State" maxlength="2" required>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <input id="zip" name="zip" type="text" class="form-control" placeholder="Zip" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <select id="text_agreement" name="text_agreement" type="custom-select" class="form-control" required>
                      <option value="" disabled selected>Receive Text Messages?</option>
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <input id="hphone" name="hphone" type="text" class="form-control" placeholder="Home Phone (555-555-5555)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="555-555-5555">
                  </div>
                  <div class="form-group">
                    <input id="cphone" name="cphone" type="text" class="form-control" placeholder="Cell Phone (555-555-5555)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="555-555-5555" required>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="chapter">Chapter</label>
                    <input id="chapter" name="chapter" type="text" class="form-control" value="<?php echo $json['chapter']; ?>" disabled>
                    <input id="chapter" name="chapter" type="hidden" class="form-control" value="<?php echo $json['chapter']; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="bsa_id">BSA ID</label>
                    <input id="bsa_id" name="bsa_id" type="text" class="form-control" value="<?php echo $json['bsaID']; ?>" disabled>
                    <input id="bsa_id" name="bsa_id" type="hidden" class="form-control" value="<?php echo $json['bsaID']; ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="dob" class="required">Birthdate</label>
                    <input id="dob" name="dob" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" type="text" class="form-control" placeholder="MM-DD-YYYY" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="rank">BSA Rank</label>
                    <select id="rank" name="rank" type="custom-select" class="form-control">
                      <option value="None">Not Applicable</option>
                      <option value="First">First Class</option>
                      <option value="Star">Star</option>
                      <option value="Life">Life</option>
                      <option value="Eagle">Eagle</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="level">Membership Level</label>
                    <input id="level" name="level" type="text" class="form-control" value="<?php echo $json['obv']; ?>" disabled>
                    <input id="level" name="level" type="hidden" class="form-control" value="<?php echo $json['obv']; ?>">
                  </div>
                </div>
              </div>
              <hr>
              </hr>
              <div class="form-row">
                <div class="col-md-12">
                  <h3>Payment Options</h3>
                  <p>For NOAC 2022, there are two different payment schedules.<br><br><b>Option 1:</b> Pay the full amount by December 7th, 2021 and receive a $50 discount.<br><br><b>Option 2:</b> Pay in equal payments due by January 20th, February 20th, and (for adults) March 20th.<br><br>Please select which payment schedule you'd like. This is a commitment and can not be changed later.</p>
                  <div class="form-group">
                    <select id="payment" name="payment" type="custom-select" class="form-control" required>
                      <option value="" disabled selected>Select an Option</option>
                      <option value="" disabled>Option 1 - Pay in Full</option>
                      <option value="2">Option 2 - Payment Schedule</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              </hr>
              <div class="form-row">
                <div class="col-md-12">
                  <h3>American Indian Affairs</h3>
                  <p>I plan on participating in AIA competitions at NOAC 2022.</p>
                  <div class="form-group">
                    <select id="aia_check" name="aia_check" type="custom-select" class="form-control" required>
                      <option value="0" selected>No</option>
                      <option value="1">Yes</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="aia">Please describe which AIA competitions you plan on participating in: (only answer if you checked the box above)</label>
                    <textarea id="aia" name="aia" rows="2" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <hr>
              </hr>
              <div class="form-row">
                <div class="col-md-12">
                  <h3 class="required">Emegency Contact Information</h3>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input id="ecfn" name="ecfn" type="text" class="form-control" placeholder="First Name" required>
                  </div>
                  <div class="form-group">
                    <input id="ecln" name="ecln" type="text" class="form-control" placeholder="Last Name" required>
                  </div>
                  <div class="form-group">
                    <input id="ecrelationship" name="ecrelationship" type="text" class="form-control" placeholder="Relationship" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input id="ecemail" name="ecemail" type="email" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <input id="ecphone" name="ecphone" type="text" class="form-control" placeholder="Phone (555-555-5555)" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="555-555-5555" required>
                  </div>
                </div>
              </div>
              <hr></hr>
              <div class="form-row">
                <div class="col-md-12">
                  <h3>Conduct and Commitment Agreement</h3>
                  <p>I understand that the Contingent fees are $600/875/Arrowman which include NOAC registration, transportation to the event, all meals during the Conference, selected meals while travelling and Contingent spirit items as determined by the Lodge NOAC Committee.<br><br>As a member of the Order of the Arrow and wanting to attend the 2022 NOAC, I will do the following:
                  <ol>
                    <li>Attend all contingent meetings for NOAC 2022 which will be held during regular Lodge weekends or as otherwise scheduled prior to departure.</li>
                    <li><b>Pay the Fee presented by the Lodge which is not refundable, but fully transferrable to another person. If I am unable to attend NOAC, I understand that it is my responsibility to find a replacement for my registration or forfeit.</b></li>
                    <li>I will attend all evening shows with the Lodge Contingent and wear the uniform indicated by the Contingent Leadership.</li>
                    <li>I will not leave the UT campus without the expressed consent of the Contingent Leadership.</li>
                    <li>I will be in the dorm by our curfew.</li>
                    <li>I will obey all NOAC 2022 and Lodge Rules; I will set the example as a proper Arrowman and be a representative of our Lodge. I will follow all instructions given to me by the Contingent leadership.</li>
                    <li>I will follow the priorities of activities set by the group and stay with the plan.</li>
                    <li>I will participate in the Founder's Day Activities and assist as requested.</li>
                    <li>I will show Lodge Spirit by participating actively in all events.</li>
                    <li>If I am 18 years of age or older while at NOAC 2022, I will have current certification for Youth Protection Training.</li>
                    <li>I will wear my full field uniform during meals, evening shows, and when other events request or require it. I understand that this includes proper scout pants.</li>
                    <li>I will accept leadership responsibilities as they may be assigned to me and carry them out to the best of my ability.</li>
                    <li>I will carry with me to NOAC any medications that are prescribed in my name on a regular basis and disclose all medical conditions for my own safety and the safety of the Contingent. If I am under 18, I will designate an adult to assist me with any medications and will indicate this on my health form.</li>
                    <li>I agree that any violation of the Contingent or NOAC policies may result in my immediate dismissal from the delegation and I agree to bear the cost of return transportation as may be determined by the Lodge.</li>
                    <li>I will make scheduled payments according to the attached payment plan.</li>
                  </ol>
                  </p>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input id="signature" name="signature" type="text" class="form-control" placeholder="Please type your full name if you agree to the contract above." required>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input id="parent" name="parent" type="text" class="form-control" placeholder="Please type your parent's full name if you are under 18 and they agree to the contract above.">
                  </div>
                </div>
              </div>
              <a href="index.php?bsaID=<?php echo $bsaID; ?>&status=3" class="btn btn-secondary">Cancel</a>
              <input type="submit" class="btn btn-primary" value="Submit">
              <div class="my-2"><small class="text-muted">Note: You will not be allowed to edit after this has submitted!</small></div>
            </form>
          </div>
        </div>
  </div>
<?php
      } else {
        //no bsaID
?>
  <div class="card col-md-6 mx-auto">
    <div class="card-body">
      <h5 class="card-title">ERROR | Please enter your BSA ID to get started</h5>
      <form action='/participant/check.php' method="get">
        <div class="form-group">
          <label for="bsaID">BSA ID</label>
          <input type="text" id="bsaID" name="bsaID" class="form-control">
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
      </form>
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

</body>

</html>
