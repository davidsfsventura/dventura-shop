<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="{{ asset('assets/css/accountinfo.css') }}" />
  <link rel="icon" href="{{ asset(" assets/img/main_logo.png") }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Account Info</title>
  @include('components.navigationBar')
  @include('components.backgroundwave')
  <script>
    var infoDivMain = "";
    let infoDivEmail = '\
      <form name="ConfirmChangeEmail" id="ConfirmChangeEmail" action="/users/changeemail" method="post"> \
        @csrf\
      <div class="email form__group field">\
        <input readonly type="email" class="form__field" oninvalid="closeConfPopup();" placeholder="Email" name="email" id="email"\
        value="{{ Session::get("email") }}" oninput="confChanges(document.getElementById(`email`).value)" required/>\
        <i style="color: #ea4646" id="editemail"\
        onclick="EditField(document.getElementById(`email`).id, this.id)" class="editinput fa-solid fa-pencil fa-lg">\
        </i>\
        <label for="name" class="form__label">Email</label>\
      </div>\
        <br>\
        <button style="position:absolute" id="confchangebtn"\
         onclick="openConfPopup();document.getElementById(`ChooseFormSubmit`).setAttribute(`form`, `ConfirmChangeEmail`);"\
        class="btn-continue" type="button">Confirm Change</button>\
        </form>';

    let infoDivUsername = '\
        <form name="ConfirmChangeUsername" id="ConfirmChangeUsername" action="/users/changeusername" method="post"> \
        @csrf\
      <div class="username form__group field">\
        <input maxlength="12" readonly type="text" class="form__field" oninvalid="closeConfPopup();" placeholder="Username" name="username" id="username"\
        value="{{ Session::get("username") }}" oninput="confChanges(document.getElementById(`username`).value)"required />\
        <i style="color: #ea4646" id="editusername" onclick="EditField(document.getElementById(`username`).id, this.id)" \
        class="editinput fa-solid fa-pencil fa-lg"></i>\
        <label for="name" class="form__label">Username</label>\
      </div>\
        <br>\
        <button style="position:absolute" id="confchangebtn"\
        onclick="openConfPopup();document.getElementById(`ChooseFormSubmit`).setAttribute(`form`, `ConfirmChangeUsername`);" \
        class="btn-continue" type="button">Confirm Change</button>\
        </form>';


    let infoDivPassword = '\
        <form name="ConfirmChangePass" id="ConfirmChangePass" action="/users/changepassword" method="post"> \
        @csrf\
        <div class="pass form__group field">\
          <input disabled="disabled" readonly type="password" class="form__field" oninvalid="closeConfPopup();" placeholder="Password" name="password" id="password" \
          oninput="confChanges(document.getElementById(`password`).value)"required />\
          <i style="color: #ea4646;margin-left:0.62rem" id="editpassword" onclick="EditField(document.getElementById(`password`).id, this.id)" \
          class="editinput fa-solid fa-pencil fa-lg"></i>\
              <label for="name" class="form__label">Current Password</label>\
        </div>\
        <div  class="pass form__group field">\
          <input readonly disabled="disabled" oninvalid="closeConfPopup();" type="password" class="form__field" placeholder="New Password" name="newpass" id="newpass" \
          required />\
            <label for="name" class="form__label">New Password</label>\
        </div>\
        <div class="pass form__group field">\
          <input readonly disabled="disabled" oninvalid="closeConfPopup();" type="password" class="form__field" placeholder="Confirm New Password"\
          name="confnewpass" id="confnewpass" required />\
          <label for="name" class="form__label">Confirm New Password</label>\
        </div>\
        <br>\
        <button style="position:absolute" id="confchangebtn" \
        onclick="openConfPopup();document.getElementById(`ChooseFormSubmit`).setAttribute(`form`, `ConfirmChangePass`);"\
        class="btn-continue" type="button">Confirm Change</button>\
        </form>';
  </script>
</head>

<body>
  @error('2fasuccess')
  <div class="popup open-popup" id="popup2fa">
    <img src="{{ asset('assets/img/thumbs up.png') }}" />
    <h2>2 Factor Authenticator</h2>
    <p style="color: white;">{{ $message }}</p>
    <button type="button" class="popupbutton"
      onclick="document.getElementById('popup2fa').classList.remove('open-popup');" style="margin-left: 1rem">
      Ok
    </button>
  </div>
  @enderror
  @error('accountverified')
  <div class="popup open-popup" id="popupaccverify">
    <img src="{{ asset('assets/img/thumbs up.png') }}" />
    <h2>Account Verification</h2>
    <p style="color: white;">{{ $message }}</p>
    <a href="/users/logout"><button type="button" class="popupbutton"
        onclick="document.getElementById('popupaccverify').classList.remove('open-popup');" style="margin-left: 1rem">
        Ok
      </button>
    </a>
  </div>
  @enderror
  @error('code')
  <div class="popup open-popup" id="popupcode">
    <img src="{{ asset('assets/img/exclamation mark.jpeg') }}" />
    <h2>SECRET CODE</h2>
    <p style="color: red;">{{ $message }}</p>
    <button type="button" class="popupbutton"
      onclick="document.getElementById('popupcode').classList.remove('open-popup');" style="margin-left: 1rem">
      Saved
    </button>
  </div>
  @enderror
  @error('profilepic')
  <div class="popup open-popup" id="popupimage">
    <img src="{{ asset('assets/img/exclamation mark.jpeg') }}" />
    <h2>Profile Picture</h2>
    <p style="color: red;">{{ $message }}</p>
    <button type="button" class="popupbutton"
      onclick="document.getElementById('popupimage').classList.remove('open-popup');" style="margin-left: 1rem">
      Got it!
    </button>
  </div>
  @enderror
  <div class="main-container">

    <div class="tab-container">
      <?php
      $email = Session::get('email');
      $imagestring = DB::table('users')->where('email', $email)->value('image');
      if ($imagestring == NULL) {
      ?>
      <img class="img-set" onclick="openPopup()" src="{{ asset('assets/uploads/default.png') }}">
      <?php
          } else {
          ?>
      <img class="img-set" onclick="openPopup()" src="{{ asset('assets/uploads/') }}/<?= $imagestring ?>">
      <?php }
        
      ?>

      <div class="item">
        <button id="emailbtn" onclick="email()">Email</button>
      </div>
      <div class="item">
        <button id="usernamebtn" onclick="username()">Username</button>
      </div>
      <div class="item">
        <button id="passwordbtn" onclick="password()">Password</button>
      </div>
      <div class="item logoutitem">
        <a href="/users/logout"><button>Logout</button></a>
      </div>
      <div class="Mobile">
        <div style="margin-right:2.5rem;margin-left:0.4rem" class="MobileFlex">
          <div class="btnMobile">
            <button id="emailbtn" onclick="email()">Email</button>
          </div>
          <div class="btnMobile">
            <button id="usernamebtn" onclick="username()">Username</button>
          </div>
        </div>
        <div class="MobileFlex">
          <div class="btnMobile">
            <button id="passwordbtn" onclick="password()">Password</button>
          </div>
          <div class="btnMobile">
            <a href="/users/logout"><button>Logout</button></a>
          </div>
        </div>
      </div>
      <div class="info-container">
        <h2 onclick="showAll()" class="hello">Welcome back {{ Session::get('username') }} 😄</h2>
        <div id="infodiv">
          <div class="email form__group field">
            <input name="loggedemail" readonly type="email" class="form__field" placeholder="Email"
              value="{{Session::get('email')}}" />
            <label for="name" class="form__label">Email</label>
          </div>
          <div style="margin-top: 10px" class="username form__group field">
            <input name="loggedusername" readonly type="text" class="form__field" placeholder="Username"
              value="{{Session::get('username')}}" />
            <label for="name" class="form__label">Username</label>
          </div>
          <div style="margin-top: 10px" class="pass form__group field">
            <input name="loggedpass" readonly disabled="disabled" type="password" class="form__field"
              placeholder="Current Password" value="Password" />
            <label for="name" class="form__label">Current Password</label>
          </div>
          @php
          $checkAccountVerified = DB::table('users')->where('email', Session::get('email'))->value('verified_acc');
          if ($checkAccountVerified == "true") {
          if (DB::table('users')->where('email', Session::get('email'))->value('2fa_active') == "false") {
          @endphp
          <a href="/users/activate2fa"><button class="btn-verify">Enable 2FA</button></a>
          @php
          }else {
          @endphp
          <form style="display:inline" action="/users/delete2fa" name="ConfirmDelete2FA" id="ConfirmDelete2FA"
            method="POST">
            @csrf
            <button type="button" id="delete2fabtn" class="btn-delete" onclick="openConfPopup();
            document.getElementById('ChooseFormSubmit').setAttribute('form', 'ConfirmDelete2FA');">
              Disable 2FA</button>
          </form>
          @php
          }
          }
          else{
          @endphp
          <a href="/users/verifyaccount"><button class="btn-verify">Verify Account</button></a>
          @php
          }
          @endphp
          <form style="display:inline" action="/users/deleteaccount" name="ConfirmAccDelete" id="ConfirmAccDelete"
            method="POST">
            @csrf
            <button id="deleteaccountbtn"
              onclick="openConfPopup();document.getElementById('ChooseFormSubmit').setAttribute('form', 'ConfirmAccDelete');"
              class="btn-delete" type="button">Delete Account</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="popup" id="popup">
    <img src="{{ asset('assets/img/question mark.png') }}" />
    <i class="closepopup fa-solid fa-x fa-lg" onclick="closePopup();"></i>
    <h2>Profile Picture</h2>
    <p>Do you wish to change or remove your profile picture?</p>
    <form name="pictureForm" id="pictureForm" action="/users/profilepicture" method="post"
      enctype="multipart/form-data">
      @csrf
      <button type="button" name="changepicture" value="Change" class="popupbutton"
        onclick="document.getElementById('fileInput').click();">
        Change
      </button>
      <input name="fileInput" id="fileInput" type="file" accept="image/png, image/jpeg, image/jpg" style="display: none"
        onchange="pictureForm.submit()" />
      <button name="removepicture" value="Remove" type="submit" class="popupbutton removepic" onclick="closePopup()"
        style="margin-left: 1rem">
        Remove
      </button>
    </form>
  </div>
  <div class="popup" id="confpopup">
    <img src="{{ asset('assets/img/exclamation mark.jpeg') }}" />
    <i class="fa-solid fa-x fa-lg" onclick="closeConfPopup();"></i>
    <h2>Confirm Changes</h2>
    <p>Are you sure you want to change this?</p>
    <button id="ChooseFormSubmit" form="" type="submit" class="popupbutton yes">
      Yes
    </button>
    <button type="button" name="cancel" class="popupbutton" onclick="closeConfPopup()" style="margin-left: 1rem">
      No
    </button>
  </div>

  <script alt="Conf Changes CurrentValue">
    function confChanges(currentvalue) {
      if (currentvalue == "{{ Session::get('email') }}" || currentvalue == "{{ Session::get('username') }}") {
        document.getElementById('confchangebtn').style.display = "none";
      } else if (currentvalue !== "{{ Session::get('email') }}" || currentvalue !== "{{ Session::get('username') }}") {
        document.getElementById('confchangebtn').style.display = "block";
      }
    }
  </script>
  <script alt="Edit Field JS">
    function EditField(inputid, editid) {
      $infodiv = document.querySelector('#infodiv');
      if (document.getElementById(inputid).readOnly == true) {
        document.getElementById(inputid).readOnly = false;
        document.getElementById(editid).style.color = "#47E038";
        document.getElementById(inputid).focus();
        if (inputid === "password") {
          document.getElementById('password').disabled = false;
          document.getElementById('password').focus();
          document.getElementById('newpass').disabled = false;
          document.getElementById('newpass').readOnly = false;
          document.getElementById('confnewpass').disabled = false;
          document.getElementById('confnewpass').readOnly = false;
        }
      } else if (document.getElementById(inputid).readOnly == false) {
        document.getElementById(editid).style.color = "#ea4646";
        document.getElementById(inputid).readOnly = true;
        if (inputid === "password") {
          document.getElementById('password').disabled = true;
          document.getElementById('newpass').disabled = true;
          document.getElementById('newpass').readOnly = true;
          document.getElementById('confnewpass').disabled = true;
          document.getElementById('confnewpass').readOnly = true;
        }
      }
    }
  </script>
  <script alt="Info Change">
    function email() {
      document.getElementById('infodiv').innerHTML = infoDivEmail;
    }

    function username() {
      document.getElementById('infodiv').innerHTML = infoDivUsername;
    }

    function password() {
      document.getElementById('infodiv').innerHTML = infoDivPassword;
    }

    function showAll() {
      document.getElementById('infodiv').innerHTML = infoDivMain; 
    }
  </script>

  <script alt="Image Popup JS">
    let popup = document.getElementById("popup");

    function openPopup() {
      popup.classList.add("open-popup");
    }

    function closePopup() {
      popup.classList.remove("open-popup");
    }
  </script>
  <script alt="Confirmation Popup JS">
    let confpopup = document.getElementById("confpopup");

    function openConfPopup() {
      confpopup.classList.add("open-popup");
    }

    function closeConfPopup() {
      confpopup.classList.remove("open-popup");
    }
  </script>
  @error("emailerror")
  <script alt="Email Error JS">
    document.getElementById("emailbtn").click();
    $innerhtml = document.getElementById('infodiv').innerHTML;
    document.getElementById('infodiv').innerHTML = $innerhtml + '<p style="margin-left:2rem;margin-top:-20px; \
  color:#ea4646">{{$message}}</p>';
  </script>
  @enderror
  @error("passworderror")
  <script alt="Password Error JS">
    document.getElementById("passwordbtn").click();
    $innerhtml = document.getElementById('infodiv').innerHTML;
    document.getElementById('infodiv').innerHTML = $innerhtml + '<p style="margin-left:2rem;margin-top:-20px; \
  color:#ea4646">{{$message}}</p>';
  </script>
  @enderror
  <script>
    infoDivMain = document.getElementById('infodiv').innerHTML;
  </script>
</body>

</html>