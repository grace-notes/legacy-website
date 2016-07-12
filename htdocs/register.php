<?php ob_start(); ?><!DOCTYPE html>

<html>
<head>
<title>Grace Notes Student Registration</title>
<meta name="description" content=
"Grace Notes provides verse-by-verse Bible studies and a library of related categorical and historical studies.">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php require "head.html"; ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- this is for the form validation -->
<!-- <script src='bootstrapValidator.js'></script>
<script src='registration-validation.js'></script> -->

<script>
(function($) {
  var toggleExtra = function() {
    if ($("input[name=first]:checked").val() == "yes") {
      $('.first-time').removeClass("hidden");
    } else {
      $('.first-time').addClass("hidden");
    }
  };
  $(document).ready(function() {
    $("input[name=first]").change(toggleExtra);
    toggleExtra();

    $('#register').submit(function(e) {
      var captcha = $("#g-recaptcha-response"), capchamsg;
      
      if (captcha.length == 0 || captcha.val() == "") {
        if (captchamsg = $('#captchamsg'), captchamsg.length == 0) {
          captchamsg = $("<div/>").attr('id', 'captchamsg').html("You must complete the captcha.").addClass("alert alert-danger").appendTo($(".g-recaptcha"));
        }
        e.preventDefault();
      }
    });
  });
})(jQuery);
</script>

<style>
label {
  font-weight: bold;
  font-size: 110%;
  display: block;
  margin: 1em 0 0.2em;
}

select, input[type=text], input[type=email], input[type=number], textarea {
  border: 1px solid #777;
  width: 100%;
  padding: 1px;
  font-size: 110%;
  line-height: 1.4;
  background: white;
}

input[type=submit] {
  font-size: 130%;
  font-weight: bold;
  border: none;
  color: white;
  background: #9A8944;
  display: block;
  width: 100%;
  cursor: pointer;
  padding: 8px;
  text-transform: uppercase;
  text-align: center;
  margin: 10px 0;
}

fieldset {
  border: none;
  border-top: 1px solid #999;
  padding: 10px 0;
  margin: 10px 0;
}

.hidden {
  display: none;
}

</style>
</head>

<body class="registration-form">
<script type="text/javascript"> /* Google Analytics Script */
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-3622200-1']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<?php
function formvalue($name) {
  return isset($_REQUEST[$name]) ? filter_var($_REQUEST[$name], FILTER_SANITIZE_STRING) : "";
}
?>

<div class="container">
<?php include "header.html"; ?>

  <div class="content">
    <h1>Grace Notes Student Registration</h1>
    <p>Please complete this registration form for Grace Notes studies. If this is 
    the first time you have registered, please complete the optional fields below 
    which help us to understand the impact and effectiveness of the Grace Notes
    ministry.</p>

<?php if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'register'): ?>
<div class="alerts">
  <?php require './forms/registration.php'; ?>
</div>
<?php endif; ?>

    <form id="register">
      <label for="course" class="required">Choose a course to begin.</label>
      <p>If this is your first time to sign-up, it is recommended to begin with the introductory series.</p>
      <select name="course" required>
        <?php include "./course-options.html"; ?>
      </select>

      <p><label for="name" class="required">Full Name</label>
      <input name="name" type="text" required value="<?php echo formvalue('name'); ?>" placeholder="Dr. John Smith, Sr"></p>

      <p><label for="email" class="required">E-mail Address</label>
      <input name="email" type="email" value="<?php echo formvalue('email'); ?>" required></p>

      <p>Is this the first time you have registered for a Grace Notes course?</p>
      <label for="firstyes"><input type="radio" name="first" value="yes" id="firstyes" <?php if (formvalue('first') == 'yes'): ?>checked=checked<?php endif; ?> required>Yes, this is my first course.</label>
      <label for="firstno"><input type="radio" name="first" value="no" id="firstno" <?php if (formvalue('first') == 'no'): ?>checked=checked<?php endif; ?> required> No, I have registered before.</label>

      
      <fieldset class="first-time <?php if (formvalue('first') != 'yes') echo "hidden"; ?>">

        <h2>First time registrants</h2>

        <p><label for="address">Mail Address (street address or P. O. Box)</label>
        <input name="address" value="<?php echo formvalue('address'); ?>" type="text" placeholder="123 Elm St #322"></p>
        
        <p><label for="city">City, State/Province, Country, Mail Code</label>
        <input name="city" value="<?php echo formvalue('city'); ?>" type="text" placeholder="Austin, TX, USA 78701"></p>
        
        <p><label for="hs">Have you completed high school or equivalency?</label>
        <label for="hsyes"><input type="radio" name="hs" value="YES" <?php if (formvalue('hs') == 'YES'): ?>checked=checked<?php endif; ?> id="hsyes"> YES</label>
        <label for="hsno"><input type="radio" name="hs" value="NO" <?php if (formvalue('hs') == 'NO'): ?>checked=checked<?php endif; ?> id="hsno"> NO</label></p>
        
        <p><label for="college">College or University Education </label>
        <select name="college">
          <option value="">Select</option>
          <option value="none" <?php if (formvalue('college') == 'none') echo 'selected=selected'; ?>>None</option>
          <option value="partial" <?php if (formvalue('college') == 'partial') echo 'selected=selected'; ?>>Unfinished</option>
          <option value="bachelor" <?php if (formvalue('college') == 'bachelor') echo 'selected=selected'; ?>>Bachelors degree</option>
          <option value="post-grad" <?php if (formvalue('college') == 'post-grad') echo 'selected=selected'; ?>>Post-graduate degree</option>
        </select></p>
        
        <p><label for="work">Work Experience (types of jobs, trades) </label>
        <textarea name="work" rows="4"><?php echo formvalue('work'); ?></textarea></p>
        
        <label for="testimony">PERSONAL TESTIMONY</label> 
        <p>Please explain how you came to accept Jesus Christ as Savior. Describe how your Christian life has progressed since then, in terms of spiritual growth (edification).</p>
        <textarea name="testimony" rows="7" cols="50"><?php echo formvalue('testimony'); ?></textarea>

        <label for="ministry_prepare">MINISTRY PREPARATION</label>
        <p>For what types of personal ministry would you like to prepare (e.g. teaching, evangelism, pastor)?</p>
        <textarea rows=2 name="ministry_prepare"><?php echo formvalue('ministry_prepare'); ?></textarea>
        
        <label for="bible_teaching">BIBLE TEACHING</label>
        <p>If you do regular Bible teaching, state what kind of classes you teach.</p>
        <textarea name="bible_teaching" type="text" ><?php echo formvalue('bible_teaching'); ?></textarea>
      </fieldset>
      <fieldset name="pastors" class="first-time">
        <h2>PASTORS <small>– please answer the following</small></h2>
        
        <p><label for="pastor_background">How did you become a pastor?  How long have you been a pastor?</label>
        <textarea name="pastor_background" rows="7" cols="50"><?php echo formvalue('pastor_background'); ?></textarea></p>

        <p><label for="church_name">What is your church’s name and address?</label>
        <input name="church_name" value="<?php echo formvalue('church_name'); ?>" type="text" ></p>
        
        <p><label for="attendance">What is the average attendance at your church?</label>
        <input name="attendance" value="<?php echo formvalue('attendance'); ?>" type="number" ></p>
        
        <p><label for="teaching">What type of teaching do you do at your church (e.g. sermons, expository; verse by verse)?</label>
        <input name="teaching" value="<?php echo formvalue('teaching'); ?>" type="text" ></p>

      </fieldset>

      <label>Other Comments</label>
      <textarea name="comments"><?php echo formvalue('comments'); ?></textarea>
      <div class="g-recaptcha" data-sitekey="6Ldj_wATAAAAAIfs9jC-sdglZ7Y127NnxiBSHwAH"></div>
      <input type="hidden" name="action" value="register">
      <input type="submit" value="Submit Registration">
    </form>

  </div>
</div>
<<?php include "footer.html"; ?>
</body>
</html>
