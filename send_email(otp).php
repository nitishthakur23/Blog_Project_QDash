<?php

// To Remove unwanted errors
error_reporting(0);

// Add your connection Code
include "config/database.php";
// Important Files
require "./PHPMailer-master/src/PHPMailer.php";
require "./PHPMailer-master/src/SMTP.php";
require "./PHPMailer-master/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Email From Form Input
$send_to_email = $_POST["email"];
$_SESSION['send_to_email']=$send_to_email;

// Generate Random 6-Digit OTP
$verification_otp = random_int(1000, 9999);
$_SESSION['verification_otp'] = $verification_otp;

function sendMail($send_to, $otp) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Enter your email ID
    $mail->Username = "qdashofficeal@gmail.com";
    $mail->Password = "zgvj pvrb tpmg mkkf";

    // Your email ID and Email Title
    $mail->setFrom("qdashofficeal@gmail.com", "QDash");

    $mail->addAddress($send_to);

    // You can change the subject according to your requirement!
    $mail->Subject = "Account Activation";

    // You can change the Body Message according to your requirement!
    $mail->Body = "Hello, Your account registration is successfully done! Now activate your account with OTP {$otp}.";
    $mail->send();
}

sendMail($send_to_email, $verification_otp);

?>
    <button type="submit" name="Submit" data-toggle="modal" data-target="#exampleModalCenter">Subscribe</button>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container_form">
          <h4>Enter OTP Code</h4>
          <form action="verify_handler.php" method="POST">
            <div class="email-form-input">
              <input type="number" class="email-form-number" name="input1" />
              <input type="number" class="email-form-number" name="input2" disabled />
              <input type="number" class="email-form-number" name="input3"disabled />
              <input type="number" class="email-form-number" name="input4" disabled />
            </div>
            <button class="email-form-button" id="email-form-buttonID">Verify OTP</button>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  const inputs = document.querySelectorAll(".email-form-number"),
    button = document.getElementById("email-form-buttonID");
  // iterate over all inputs
  inputs.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
      // This code gets the current input element and stores it in the currentInput variable
      // This code gets the next sibling element of the current input element and stores it in the nextInput variable
      // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
      const currentInput = input,
        nextInput = input.nextElementSibling,
        prevInput = input.previousElementSibling;

      // if the value has more than one character then clear it
      if (currentInput.value.length > 1) {
        currentInput.value = "";
        return;
      }
      // if the next input is disabled and the current value is not empty
      //  enable the next input and focus on it
      if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
        nextInput.removeAttribute("disabled");
        nextInput.focus();
      }

      // if the backspace key is pressed
      if (e.key === "Backspace") {
        // iterate over all inputs again
        inputs.forEach((input, index2) => {
          // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
          // and the previous element exists, set the disabled attribute on the input and focus on the previous element
          if (index1 <= index2 && prevInput) {
            input.setAttribute("disabled", true);
            input.value = "";
            prevInput.focus();
          }
        });
      }
      //if the fourth input( which index number is 3) is not empty and has not disable attribute then
      //add active class if not then remove the active class.
      if (!inputs[3].disabled && inputs[3].value !== "") {
        button.classList.add("active");
        return;
      }
      button.classList.remove("active");
    });
  });

  //focus the first input which index is 0 on window load
  window.addEventListener("load", () => inputs[0].focus());
</script>
