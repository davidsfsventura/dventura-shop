<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
  <link rel="stylesheet" href="{{ asset('assets/css/feedback.css') }}" />
  <title>Diodav</title>
  @include('components.navbar')
  @include('components.backgroundwave')
  @include('components.default')

</head>

<body>
  @error('SendSuccess')
  <div class="popup open-popup" id="popup">
    <img src="{{ asset('assets/img/thumbs up.png') }}" />
    <h2>Thank you for your feedback</h2>
    <p style="color: #47E038">{{ $message }}</p>
    <button type="button" class="popupbutton" onclick="document.getElementById('popup').classList.remove('open-popup');"
      style="margin-left: 1rem">
      Thanks
    </button>
  </div>
  @enderror
  <div class="main-container">
    <h1 class="header">Send Feedback</h1>
    <div class="inputs">
      <form action="/feedback/sendfeedback" id="sendfeedback" method="post">
        @csrf
        <div class="form__group field">
          <input type="email" class="form__field" placeholder="Email" oninvalid="closeConfPopup();" name="sender_email"
            id="sender_email" value="{{old('sender_email')}}" required />
          <label for="sender_email" class="form__label">Email</label>
        </div>
        <div class="form__group field">
          <input type="text" class="form__field" minlength="3" placeholder="Title" name="email_title" id="email_title"
            oninvalid="closeConfPopup();" value="{{old('email_title')}}" required />
          <label for="email_title" class="form__label">Subject</label>
        </div>
        <textarea class="email_content" name="email_content" minlength="10" id="email_content" rows="8"
          placeholder="Body" oninvalid="closeConfPopup();" required></textarea>
        <button type="button" class="btn-send"
          onclick="openConfPopup();document.getElementById(`ChooseFormSubmit`).setAttribute(`form`, `sendfeedback`);">Send</button>
      </form>
    </div>
  </div>

  <div class="popup" id="confpopup">
    <img src="{{ asset('assets/img/exclamation mark.jpeg') }}" />
    <i class="fa-solid fa-x fa-lg" onclick="closeConfPopup();"></i>
    <h2>Confirm Feedback</h2>
    <p>Are you sure you want to send this?</p>
    <button id="ChooseFormSubmit" form="" type="submit" class="popupbutton yes">
      Yes
    </button>
    <button type="button" name="cancel" class="popupbutton" onclick="closeConfPopup()" style="margin-left: 1rem">
      No
    </button>
  </div>

  <script>
    let confpopup = document.getElementById("confpopup");

        function openConfPopup() {
            confpopup.classList.add("open-popup");
        }

        function closeConfPopup() {
            confpopup.classList.remove("open-popup");
        }
  </script>

  <script>
    var email = document.getElementById('sender_email');
        var emailTitle = document.getElementById('email_title');
        var emailContent = document.getElementById('email_content');
  </script>
</body>

</html>