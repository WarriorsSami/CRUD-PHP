<?php
	require_once ("Controllers/authControllers.php");
    require_once ("Controllers/userProfileControllers.php");
	
	if (!isset ($_SESSION['id'])) {
        $_SESSION['logout'] = true;
        header ('location: homepage.php');
        exit (0);
    }

    if (isset ($_SESSION['id']) and $_SESSION['verified'] == 0) {
        $_SESSION['illegal-access'] = true;
        header ('location: homepage.php');
        exit (0);
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Team</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">

    <link rel="icon" href="images/favi1.jpg" type="image/gif" sizes="16x16">

    <!-- Fontawesome Icons -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <!-- Custom styles for this template -->
    <link href="css_util/carousel.css" rel="stylesheet"/>

    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="https://mdbootstrap.com/legacy/4.3.2/assets/compiled.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>

    <style>
      p, h1, h2, h3 {
        color: whitesmoke;
        font-weight: bolder;
      }
    </style>
  </head>

  <body>
    <?php //test user's existence
    checkUser ();?>

    <div class="container text-left">
        <div class="modal fade" id="menu" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-body">
                        <div class="list-group">
                            <a class="btn btn-outline-light" href="profile.php"><i class="fa fa-user" style="color: coral;"></i> Profile</a>
                            <br>
                            <a class="btn btn-outline-light" href="conversations.php"><i class="fa fa-comment" style="color: tomato;"></i><sup>1</sup> Conversations</a>
                            <br>
                            <a class="btn btn-outline-light" href="homepage.php?logout=1"><i class="fa fa-sign-out-alt" style="color: deepskyblue;"></i> Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="homepage.php"><!--<div id="root"></div>--><h2>Tech Savvy</h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="btn btn-primary" href="homepage.php"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (!isset ($_SESSION['id'])): ?>
              <li class="nav-item">
                <a class="btn btn-info" href="login.php"><i class="fa fa-sign-in-alt" title="sign in"></i> Log In</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-info" href="signup.php"><i class="fa fa-user-plus" title="sign up"></i> Register</a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="btn btn-success" href="#"><i class="fa fa-users"></i> Meet the Team</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-success" href="main.php"><i class="fab fa-apple fa-lg"></i> CRUD App</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-success" href="quizz.php"><i class="fa fa-question"></i> Quiz</a>
            </li>
          </ul>
            <?php if (isset ($_SESSION['id'])): ?>
                <a class="btn btn-outline-dark" data-toggle="modal" data-target="#menu" href="#"><span style="color: white;"><!-- <i class="fa fa-user-circle fa-lg"></i> -->
                        <img class="rounded-circle" src=<?php echo (getImage ()); ?> alt="Generic placeholder image" width="30" height="30">
                        <span style="color: darkorange;"><?php echo (getName ()); ?></span></span></a>
            <?php endif; ?>
        </div>
      </nav>
    </header>

    <main role="main">
      <br><br><br>
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <br><br><br>
            <img class="rounded-circle" src="images/rac.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: orange;">Bogdan Mladin</span> <span style="font-size: .75em;">- DB Analyst Programmer and JavaScript Specialist</span></h2>
            <p>Buenos días a todos! I am Bogdan, the co-founder of Tech Savvy. Besides coding I highly enjoy listening to music, memes and clips of raccoons on YouTube. 😃</p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="images/warrior.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: orange;">Sami Barbut-Dica</span> <span style="font-size: .75em;">- Full Stack Programmer and CEO</span></h2>
            <p>Hi there! My name is Sami and most of you should know me as the leader of the Tech Savvy project. I also work as
            a full stack programmer in web development and I love spending my spare time improving my coding skills, practising
            calisthenics and reading SF novels. <i class="fa fa-laugh-wink"></i></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <br><br><br>
            <img class="rounded-circle" src="images/barcaS.png" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: orange;">Leonard Rudareanu</span> <span style="font-size: .75em;">- Kotlin Specialist and App Developer</span></h2>
            <p>Hello! I'm Leo and I'm one of Tech Savy producers. I like to solve C++ exercises and create apps or websites. In my free time, I love to play sports, improve all of my skills, hang out with my friends, watch TV Series and reading novels. <i class="fa fa-laugh"></i></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-4">
            <br><br><br>
            <img class="rounded-circle" src="images/teemo1.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: orange;">Elena Tirna</span> <span style="font-size: .75em;">- Front-End Specialist and Web Designer</span></h2>
            <p>Nice to meet you, my friend! My name is Elena, but my best friends know me as the Front-Ender brain behind the Tech Savvy project's scene. I am addicted to design frameworks and front-end development of a wide range of web sites. Now I enjoy my spare time taking care of my lovely pets and playing FPS and Stategy video games (I hope I will implement them on my own in the near future <i class="fa fa-laugh-wink"></i> )</p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="images/husky1.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: orange;">Bogdan Afrenie</span> <span style="font-size: .75em;">- Web Designer and Swift Specialist</span></h2>
            <p>Hello! My name is Bogdan and I am involved in the Tech Savy project's Staff. Besides investing my time in improving user experience on web sites, I love going out with my friends and taking care of my puppy. Moreover, I am an aficionado of SF movies. <i class="fa fa-smile"></i></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <br><br><br>
            <img class="rounded-circle" src="images/axe.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: orange;">Adelin Mota</span> <span style="font-size: .75em;">- JSP and JDBC Expert on Server Side Java Programming</span></h2>
            <p>Hello there! It's Adelin here and I'm one of the most aficionado Tech Savvy's Staff member. I love parties and going out in restaurants with my best friends, and thus I guide my own life as a famous quote states: 
              <q>Be in high spirits first of all</q>... And I think this helps me a lot in my server programming career. <i class="fa fa-laugh-wink"></i></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2020-2021 Company, Inc. &middot; <a href="#">Privacy</a> 
        &middot; <a href="#">Terms</a> &middot; <a href="mailto: usertechsavvy@gmail.com">Contact</a></p>
      </footer>
    </main>

    <!-- Toastr Control Panel -->
    <script src="js_util/toastr.js"></script>

    <?php if (isset ($_SESSION['login'])) {
      unset ($_SESSION['login']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('You are logged in...');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['logout'])) {
      unset ($_SESSION['logout']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Please, log in first of all!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['illegal-access'])) {
      unset ($_SESSION['illegal-access']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Please, verify your account!');
              });
      </script>
    "); } ?>

    <?php if (isset ($_SESSION['unfound-email'])) {
      unset ($_SESSION['unfound-email']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Email does not exist in database...');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['verified']) and $_SESSION['verified'] == 0) echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('A verification link has been sent to your <a href=\"https://mail.google.com\">email</a>...');
              });
      </script>
    "); ?>

    <?php if (isset ($_SESSION['sent'])) {
      unset ($_SESSION['sent']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('A recovering link has been sent to your <a href=\"https://mail.google.com\">email</a>...');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['reset'])) {
      unset ($_SESSION['reset']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('Your password has been reset...');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['verif-acc'])) {
      unset ($_SESSION['verif-acc']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('Your account has been successfully verified!');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['reconnect'])) {
      unset ($_SESSION['reconnect']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('You are already logged in!');
              });
      </script>
    ");} ?>

    <?php if (isset ($_SESSION['undef-user'])) {
      unset ($_SESSION['undef-user']);
      echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('User does not exist in our database...');
              });
      </script>
    ");} ?>
  </body>
</html>
