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

  <title>Add Adult Nomination | Occoneechee Lodge - Order of the Arrow, BSA</title>

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
                <h1 class="card-title">New Adult Nomination</h1>
                <?php $getUnitElections = $getUnitElectionsQ->fetch_assoc(); ?>
                <?php $rawadults = ($getUnitElections['numRegisteredYouth'] * (2 / 3));
                $numadults = ceil($rawadults);
                ?>
                <?php
                $adultNominationQuery = $conn->prepare("SELECT * from adultNominations where unitId = ?");
                $adultNominationQuery->bind_param("s", $getUnitElections['id']);
                $adultNominationQuery->execute();
                $adultNominationQ = $adultNominationQuery->get_result();
                //print election info
                ?>
                <?php
                if ($adultNominationQ->num_rows < $numadults) { ?>
                  <div class="form-row">
                    <div class="col-md-12">
                      <p>Each year, upon holding a troop or team election for youth candidates that results in at least one youth candidate being elected, the unit committee may nominate registered unit adults (age 21 or over) to the lodge adult selection committee. The number of adults nominated can be no more than two-third of the number of youth candidates elected, rounded up where the number of youth candidates is not a multiple of three. In addition to the two-third limit, the unit committee may nominate the currently-serving unit leader (but not assistant leaders), as long as he or she has served as unit leader for at least the previous 12 months. Recommendations of the adult selection committee, with the approval of the Scout Executive, serving as Supreme Chief of the Fire, will be candidates for induction, provided all conditions are fulfilled. </p>
                      <h3 class="required">Personal Information</h3>
                    </div>
                  </div>
                  <form action="add-nomination-process.php" method="post">
                    <div class="form-row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <input type="hidden" id="unitId" name="unitId" value="<?php echo $getUnitElections['id']; ?>">
                          <input type="hidden" id="bsaID" name="bsaID" value="<?php echo $getUnitElections['bsaID']; ?>">
                          <input type="hidden" id="unitCommunity" name="unitCommunity" value="<?php echo $getUnitElections['unitCommunity']; ?>">
                          <input type="hidden" id="unitNumber" name="unitNumber" value="<?php echo $getUnitElections['unitNumber']; ?>">
                          <input id="firstName" name="firstName" type="text" class="form-control" value="<?php echo $json['firstName']; ?>" disabled>
                        </div>
                        <div class="form-group">
                          <input id="lastName" name="lastName" type="text" class="form-control" placeholder="Last Name" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="address_line1" name="address_line1" type="text" class="form-control" placeholder="Address" required>
                        </div>
                        <div class="form-group">
                          <input id="address_line2" name="address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="city" name="city" type="text" class="form-control" placeholder="City" required>
                        </div>
                        <div class="form-row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <input id="state" name="state" type="text" class="form-control" placeholder="State" required>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input id="zip" name="zip" type="text" class="form-control" placeholder="Zip" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                          <input id="phone" name="phone" type="text" class="form-control" placeholder="Phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="555-555-5555" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="position" class="required">Unit Position</label>
                          <input id="position" name="position" type="text" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="bsa_id" class="required">BSA ID</label>
                          <input id="bsa_id" name="bsa_id" type="text" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="dob" class="required">Birthdate</label>
                          <input id="dob" name="dob" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" type="text" class="form-control" placeholder="MM-DD-YYYY" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="years_adult" class="required">Years in Scouting as an Adult</label>
                          <input id="years_adult" name="years_adult" type="text" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <hr>
                    </hr>
                    <div class="form-row">
                      <div class="col-md-12">
                        <h3>Experience</h3>
                        <p>Recommendation of adults into the Order of the Arrow should be based on the candidate’s ability to assist the Lodge in fulfilling it’s mission and is not to be considered a recognition or award. The information below will help the Lodge selection committee determine how the candidate will accomplish this goal. </p>
                        <div class="form-group">
                          <label for="training" class="required">Training Completed</label>
                          <textarea id="training" name="training" rows="2" class="form-control" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="position_held" class="required">Positions Held</label>
                          <textarea id="position_held" name="position_held" rows="2" class="form-control" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="youth_rank">Rank as a Youth Scout</label>
                          <input id="youth_rank" name="youth_rank" type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="community_activities" class="required">Community Activities</label>
                          <textarea id="community_activities" name="community_activities" rows="2" class="form-control" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="employment" class="required">Employment/Trade</label>
                          <textarea id="employment" name="employment" rows="2" class="form-control" required></textarea>
                        </div>
                      </div>
                    </div>
                    <hr>
                    </hr>
                    <div class="form-row">
                      <div class="col-md-12">
                        <h3>Camping Requirements</h3>
                        <p>The camping requirement set forth for youth candidates must be fulfilled by adults for them to be considered. To be eligible, the adult must have completed 15 days and nights of Boy Scout camping during the two-year period prior to nomination. The 15 days and nights must include one, but no more than one, long-term camp consisting of six consecutive days and five nights of resident camping, approved and under the auspices and standards of the BSA. The balance must be overnight, weekend, or other short-term camps. Include the dates and location of the resident camping experience in the space below.</p>
                        <div class="alert alert-danger" role="alert">
                          <b>For 2021 nominations only,</b> the requirement for a long-term camp of five (5) consecutive nights is relaxed. While council long-term camps should be utilized if available, any combination of short-term and/or long-term nights, in camp or virtual, that are part of a BSA unit-organized unit camping event held within the two years prior to the election may be counted toward the 15-night requirement. If long term camping has not been completed, please state that in the relevant box.
                        </div>
                        <div class="form-group">
                          <label for="short_term" class="required">Short Term Camping</label>
                          <textarea id="short_term" name="short_term" rows="2" class="form-control" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="long_term" class="required">Long Term Camping</label>
                          <textarea id="long_term" name="long_term" rows="2" class="form-control" required></textarea>
                        </div>
                      </div>
                    </div>
                    <hr>
                    </hr>
                    <div class="form-row">
                      <div class="col-md-12">
                        <h3>Nomination and Testimonials</h3>
                        <p>Selection of the adult is based upon the ability to perform the necessary functions and not for recognition of service, including current or prior achievement and position.</p>
                        <div class="form-group">
                          <label for="abilities" class="required">The individual's abilities include:</label>
                          <textarea id="abilities" name="abilities" rows="4" class="form-control" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <p>As Scouting’s National Honor Society, our purpose is to:
                          <li>Recognize those who best exemplify the Scout Oath and Law in their daily lives and through that recognition cause others to conduct themselves in a way that warrants similar recognition.</li>
                          <li>Promote camping, responsible outdoor adventure, and environmental stewardship as essential components of every Scout’s experience, in the unit, year-round, and in summer camp.</li>
                          <li>Develop leaders with the willingness, character, spirit and ability to advance the activities of their units, our Brotherhood, Scouting, and ultimately our nation.</li>
                          <li>Crystallize the Scout habit of helpfulness into a life purpose of leadership in cheerful service to others.</li>
                        </p>
                        <div class="form-group">
                          <label for="purpose" class="required">
                            This adult will be an asset to the Order of the Arrow due to demonstrated skills and abilities, which fulfill the purpose of the Order of the Arrow, in the following manner:</label>
                          <textarea id="purpose" name="purpose" rows="4" class="form-control" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="role_modal" class="required">This adult leader's membership will provide a positive role model for the growth and development of the youth members of the lodge because:</label>
                          <textarea id="role_modal" name="role_modal" rows="4" class="form-control" required></textarea>
                        </div>
                      </div>
                    </div>
                    <hr>
                    </hr>
                    <h4 class="card-title">Unit Chair's Information</h4>
                    <div class="form-row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="uc_name" name="uc_name" type="text" class="form-control" placeholder="Name" value="<?php echo $getUnitElections['uc_name']; ?>" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="uc_address_line1" name="uc_address_line1" type="text" class="form-control" placeholder="Address" value="<?php echo $getUnitElections['uc_address_line1']; ?>" required>
                        </div>
                        <div class="form-group">
                          <input id="uc_address_line2" name="uc_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)" value="<?php echo $getUnitElections['uc_address_line2']; ?>">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="uc_city" name="uc_city" type="text" class="form-control" placeholder="City" value="<?php echo $getUnitElections['uc_city']; ?>" required>
                        </div>
                        <div class="form-row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <input id="uc_state" name="uc_state" type="text" class="form-control" placeholder="State" value="<?php echo $getUnitElections['uc_state']; ?>" required>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input id="uc_zip" name="uc_zip" type="text" class="form-control" placeholder="Zip" value="<?php echo $getUnitElections['uc_zip']; ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="uc_email" name="uc_email" type="email" class="form-control" placeholder="Email" value="<?php echo $getUnitElections['uc_email']; ?>" required>
                        </div>
                        <div class="form-group">
                          <input id="uc_phone" name="uc_phone" type="text" class="form-control" placeholder="Phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="555-555-5555" value="<?php echo $getUnitElections['uc_phone']; ?>" required>
                        </div>
                      </div>
                    </div>
                    <h4 class="card-title">Unit Leader's Information</h4>
                    <div class="form-row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="sm_name" name="sm_name" type="text" class="form-control" placeholder="Name" value="<?php echo $getUnitElections['sm_name']; ?>" disabled>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="sm_address_line1" name="sm_address_line1" type="text" class="form-control" placeholder="Address" value="<?php echo $getUnitElections['sm_address_line1']; ?>" disabled>
                        </div>
                        <div class="form-group">
                          <input id="sm_address_line2" name="sm_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)" value="<?php echo $getUnitElections['sm_address_line2']; ?>" disabled>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="sm_city" name="sm_city" type="text" class="form-control" placeholder="City" value="<?php echo $getUnitElections['sm_city']; ?>" disabled>
                        </div>
                        <div class="form-row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <input id="sm_state" name="sm_state" type="text" class="form-control" placeholder="State" value="<?php echo $getUnitElections['sm_state']; ?>" disabled>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <input id="sm_zip" name="sm_zip" type="text" class="form-control" placeholder="Zip" value="<?php echo $getUnitElections['sm_zip']; ?>" disabled>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <input id="sm_emaild" name="sm_emaild" type="email" class="form-control" placeholder="Email" value="<?php echo $getUnitElections['sm_email']; ?>" disabled>
                          <input id="sm_email" name="sm_email" type="hidden" class="form-control" placeholder="Email" value="<?php echo $getUnitElections['sm_email']; ?>">
                        </div>
                        <div class="form-group">
                          <input id="sm_phone" name="sm_phone" type="text" class="form-control" placeholder="Phone" value="<?php echo $getUnitElections['sm_phone']; ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="form-row justify-content-center">
                      <div class="col-md-9">
                        <div class="form-group">
                          <input class="form-check-input" type="checkbox" value="1" id="leader_signature" required>
                          <label class="required" for="leader_signature">
                            By checking here, you, as the unit leader, testify the adult leader, who fulfills the above requirements, is recommended for membership consideration in the Order of the Arrow.
                          </label>
                        </div>
                      </div>
                    </div>
                    <a href="index.php?bsaID=<?php echo $bsaID; ?>&status=3" class="btn btn-secondary">Cancel</a>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <div class="my-2"><small class="text-muted">Note: You will not be allowed to edit after this has submitted! Your Unit Chair will be invited via email to review this submission. Make sure their email and phone number are correct!</small></div>
                  </form>
              </div>
            </div>
  </div>
<?php } else { ?>
  <div class="col-auto">
    <div class="alert alert-danger" role="alert">
      All out of nominations!
    </div>
  </div>
<?php } ?>
</div>

<?php
          } else {
?>
  <div class="alert alert-danger" role="alert">
    There are no elections in the database.
  </div>
<?php
          }
        } else {
          //bsaID bad
?>
<div class="alert alert-danger" role="alert">
  <h5 class="alert-heading">Invalid Access Key</h5>
  You have an invalid access key. Please use the personalized link provided in your email, or enter your access key below.
</div>
<div class="card col-md-6 mx-auto">
  <div class="card-body">
    <h5 class="card-title">Access Key </h5>
    <form action='' method="get">
      <div class="form-group">
        <label for="bsaID">Access Key</label>
        <input type="text" id="bsaID" name="bsaID" class="form-control">
      </div>
      <input type="submit" class="btn btn-primary" value="Submit">
    </form>
  </div>
</div>
<?php
        }
      } else {
        //no bsaID
?>
<div class="card col-md-6 mx-auto">
  <div class="card-body">
    <h5 class="card-title">Access Key </h5>
    <form action='' method="get">
      <div class="form-group">
        <label for="bsaID">Access Key</label>
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