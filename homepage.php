<?php
	require_once ("Controllers/authControllers.php");
    require_once ("Controllers/userProfileControllers.php");
	
	//reset the password for a specific user using password-token
	if (isset ($_GET['password-token'])) {
		$passwordToken = $_GET['password-token'];
		resetPassword ($passwordToken);
	}

	//verify the user using token
	if (isset ($_GET['token'])) {
		$token = $_GET['token'];
		verifyUser ($token);
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

    <title>Tech Savvy</title>

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

    <style>
      p, h1, h2, h3, h4 {
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
        <a class="navbar-brand" href="#"><!--<div id="root"></div>--><h2>Tech Savvy</h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="btn btn-primary" href="#"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="btn btn-success" href="meet.php"><i class="fa fa-users"></i> Meet the Team</a>
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
            <?php if (!isset ($_SESSION['id'])): ?>
                <a class="btn btn-info" href="login.php"><i class="fa fa-sign-in-alt" title="sign in"></i> Log In</a>
                &nbsp;&nbsp;
                <a class="btn btn-info" href="signup.php"><i class="fa fa-user-plus" title="sign up"></i> Register</a>
            <?php endif; ?>
        </div>
      </nav>
    </header>

    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="images/dblue.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h6>
                  <div class="d-flex justify-content-center">
                      <div class="content">
                          <div class="slider-wrapper">
                              Here you can
                              <div class="slider">
                                  <div class="slider-text1">launch SQL queries</div>
                                  <div class="slider-text2">discover our DB and Team</div>
                                  <div class="slider-text3">admire our front-end</div>
                              </div>
                          </div>       
                      </div>
                  </div>
                </h6>
                <h1><span style="color: lightgreen">Tech Savvy</span><span style="font-size: .69em"> - a world leader company in software production</span></h1>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Here is the place where <span style="color: lightgreen">all your digital dreams</span>
                   turn into very software projects implemented by our specialists via their tremendous
                   endeavour paid in a wide range of modern high-tech branches such as Web Development, 
                   Game Engineering, Socket Programming, 
                   IDE Development and even Embedded Firmware for modern devices.
                   <span style="color: lightgreen">So stay tuned!</span></p>
                <p><a class="btn btn-lg btn-primary" href="signup.php" role="button">Sign up today</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="images/incomp.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1><span style="color: black;">ERD Inside Company Partition</span></h1>
                <br><br><br><br><br><br><br>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="images/outcomp.jpg" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-center">
                <h1><span style="color: black;">ERD Outside Company Partition&nbsp;&nbsp;&nbsp;&nbsp;</span></h1>
                <br><br><br><br><br><br><br><br><br><br><br><br>
              </div>
            </div>
          </div>
            <div class="carousel-item">
                <img class="third-slide" src="images/chat.jpg" alt="Fourth slide">
                <div class="container">
                    <div class="carousel-caption text-center">
                        <h1><span style="color: black;">ERD Chat API&nbsp;&nbsp;&nbsp;&nbsp;</span></h1>
                        <br><br><br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="images/ai.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: skyblue;">AI and Machine Learning Department</span></h2>
            <p>Robots and many sorts of intelligent machines are already an integrated part of our lives.
              AI and ML Department brings together amazing specialists and brilliant programmers all around the world in a 
              new age environment where teamwork and discipline coexist with latest technologies and programming patterns
              in order to enhance ergonomic interactions with artificial intelligence. 
              <span style="color: skyblue;">See our neuronal networks into action!</span></p>
            <p><a class="btn btn-secondary disabled" href="#" role="button">View details &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="images/gaming.png" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: tomato; font-weight: bolder">Game Development Department</span></h2>
            <p>I am sure that all of you love video games. We too! Game Development Department demonstrates us that game
              engineering is a tremendous programming realm where everyone from the absolute beginner to the legendar expert
              come together to push our pastime for playing beyond its confinements. New age game engineers are working hard to
              improve user experience in FPS and Arcade Games using latest gamedev technologies and engines such as Godot, Unity, Unreal Engine 4 and UbiArt Framework
              <span style="color: tomato; font-weight: bolder;">See our Game Engines at highest performance!</span></p>  
            <p><a class="btn btn-secondary disabled" href="#" role="button">View details &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="images/webdev.jpg" alt="Generic placeholder image" width="140" height="140">
            <h2><span style="color: gray;">Web Development Department</span></h2>
            <p>We cannot imagine our lives in the absence of Internet. Thus we bring Internet's the most brilliant services and apps
               to you via our Web Development Department which beats uncountable records in improving and applying the latest frameworks and templates
               into very web softwares: Node.JS, Angular JS, React Js, Laravel, Codeigniter, Swing and the whole web cool stuff is engaged here.
               <span style="color: gray;">See our Servlets, Applets and DB Managers in their entire beauty!</span></p>

            <p><a class="btn btn-secondary disabled" href="#" role="button">View details &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->
        <br><br><br>
        <!--<hr class="featurette-divider">-->

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Mapping for <span style="color: orange;">Customer</span> Table. <span class="text-muted" style="font-size: .85em;">A lot of people are enjoying our softwares.</span></h2>
            <p class="lead">Customer Table defines our clients generic profile, which are stored in the data base as entities described by name, surname, email and address and are genuinely identified by using a specific ID.</p>
            <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#client" role="button">View mapping &raquo;</a>
            <a class="btn btn-secondary" href="main.php" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto rounded" style="width: 600px; height: 400px;" data-src="holder.js/500x500/auto" src="images/ai2.jpeg" alt="Generic placeholder image">
          </div>
        </div>

        <div class="container text-left">
            <div class="modal fade" id="client" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4>Customer Table Mapping</h4>
                        </div>
                        <div class="modal-body">
                            <img src="images/client3.jpg" style="width: 465px; height: 400px;" alt="client mapping">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Mapping for <span style="color: orange;">Product</span> Table. <span class="text-muted" style="font-size: .85em;">Let our awesome softwares blow your mind.</span></h2>
            <p class="lead">Product Table defines the manner we store our software articles into the data base in and help us keep tracking of a wide range of programs, games and frameworks by specifying their ID, description, requirements imposed by customers and disponibility state.</p>
            <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#produs" role="button">View mapping &raquo;</a>
            <a class="btn btn-secondary" href="produs.php" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto rounded" style="width: 600px; height: 400px;" data-src="holder.js/500x500/auto" src="images/webdev1.jpg" alt="Generic placeholder image">
            <!--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="darkgreen" fill-opacity="1" d="M0,256L48,229.3C96,203,192,149,288,154.7C384,160,480,224,576,218.7C672,213,768,139,864,128C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>-->
          </div>
        </div>

        <div class="container text-left">
            <div class="modal fade" id="produs" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4>Product Table Mapping</h4>
                        </div>
                        <div class="modal-body">
                            <img src="images/prodsoft.jpg" style="width: 465px; height: 400px;" alt="product mapping">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<hr class="featurette-divider">-->
        <br><br><br>

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Mapping for <span style="color: orange;">Order</span> Table. <span class="text-muted" style="font-size: .85em;">Analyze our history of demands.</span></h2>
            <p class="lead">Order Table invokes a friendly and efficient interface for demand execution and management by defining our workbench template for teams.
              Every customer is able to create multiple orders requesting available software articles, every software product can be involved in multiple orders, but a single order entity is defined by its deadline specified by client,
              a generated ID, the customer's ID, the product's ID and, of course, the ID of a team which receives the responsibility for the current demand and doesn't have another
              project in work.
            </p>
            <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#comanda" role="button">View mapping &raquo;</a>
            <a class="btn btn-secondary" href="comanda.php" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-5">
            <br><br><br><br><br>
            <img class="featurette-image img-fluid mx-auto rounded" style="width: 600px; height: 400px;" data-src="holder.js/500x500/auto" src="images/java.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <div class="container text-left">
            <div class="modal fade" id="comanda" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4>Order Table Mapping</h4>
                        </div>
                        <div class="modal-body">
                            <img src="images/order.jpg" style="width: 465px; height: 400px;" alt="order mapping">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<hr class="featurette-divider">-->
        <br><br><br>

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Mapping for <span style="color: orange;">Employee</span> Table. <span class="text-muted" style="font-size: .85em;">Get in touch with those people who make your dreams turn into reality.</span></h2>
            <p class="lead">Employee Table contains key informations about our software specialists, including a unique ID, their name, surname, email, address, joining date, wage, manager and team leader status and, also, IDs for team and department they work in.
              There cannot be more than one manager in a specific department or more than one team leader in a specific team. Also, an employee cannot be member of more than one team and department.
              This template help us distribute the amount of work more efficiently among departments and teams by preserving a higher level of discipline and coordination.
            </p>
            <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#angajat" role="button">View mapping &raquo;</a>
            <a class="btn btn-secondary" href="angajat.php" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-5 order-md-1">
            <br><br><br><br><br>
            <img class="featurette-image img-fluid mx-auto rounded" style="width: 700px; height: 480px;" data-src="holder.js/500x500/auto" src="images/meca.png" alt="Generic placeholder image">
          </div>
        </div>

        <div class="container text-left">
            <div class="modal fade" id="angajat" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4>Employee Table Mapping</h4>
                        </div>
                        <div class="modal-body">
                            <img src="images/angajat.jpg" style="width: 465px; height: 400px;" alt="employee mapping">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--hr class="featurette-divider">-->
        <br><br><br>

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Mapping for <span style="color: orange;">Department</span> Table. <span class="text-muted" style="font-size: .85em;">This is the main core of our company's functionality.</span></h2>
            <p class="lead">Department Table gives us the inner distribution of our employees - software engineers, expert programmers, analysts and staff - into departments which enhance their specialization level
              and help them to break the limits and confinements in their further career as team members or, even, team leaders. Every single department has a manager which organizes the responsibilities and workflow of members. Our main departments are: Game Development Department, Web Development Department,
              Machine Learning and AI Department, Mechatronics Department and many others.
            </p>
            <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#dep" role="button">View mapping &raquo;</a>
            <a class="btn btn-secondary" href="departament.php" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-5">
            <br><br><br><br>
            <img class="featurette-image img-fluid mx-auto rounded" style="width: 600px; height: 400px;" data-src="holder.js/500x500/auto" src="images/micro1.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <div class="container text-left">
            <div class="modal fade" id="dep" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4>Department Table Mapping</h4>
                        </div>
                        <div class="modal-body">
                            <img src="images/dep_team.jpg" style="width: 465px; height: 400px;" alt="dep mapping">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<hr class="featurette-divider">-->
        <br><br><br>

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Mapping for <span style="color: orange;">Project</span> Table. <span class="text-muted" style="font-size: .85em;">Explore our software projects and learn about software development.</span></h2>
            <p class="lead">Project Table defines the workflow cores of our company by transforming customer's wishes, programmer's experience and software frameworks into challenging tasks and endeavours coordinated among members of teams.
              Every project is represented by a unique ID, a deadline, working status, name and, also, the ID of a team which is working on it.
            </p>
            <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#proj" role="button">View mapping &raquo;</a>
            <a class="btn btn-secondary" href="proiect.php" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-5 order-md-1">
            <br><br><br><br>
            <img class="featurette-image img-fluid mx-auto rounded" style="width: 600px; height: 380px;" data-src="holder.js/500x500/auto" src="images/gmdv.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <div class="container text-left">
            <div class="modal fade" id="proj" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4>Project Table Mapping</h4>
                        </div>
                        <div class="modal-body">
                            <img src="images/proj.jpg" style="width: 465px; height: 400px;" alt="employee mapping">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<hr class="featurette-divider">-->
        <br><br><br>

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Mapping for <span style="color: orange;">Team</span> Table. <span class="text-muted" style="font-size: .85em;">Teams maintain constant the rhythm of software production.</span></h2>
            <p class="lead">Team Table specifies the manner our employees are distributed in workflow divisions which enhance software production by preserving a constant rhythm of work. Every single team is guided by a team leader which
              allocates tasks for members in order to essure projects development in time. Also, every team has its own project history, including past completed projects and the current one.
            </p>
            <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#team" role="button">View mapping &raquo;</a>
            <a class="btn btn-secondary" href="echipa.php" role="button">View details &raquo;</a></p>
          </div>
          <div class="col-md-5">
            <br><br><br><br>
            <img class="featurette-image img-fluid mx-auto rounded" style="width: 600px; height: 380px;" data-src="holder.js/500x500/auto" src="images/dream1.jpg" alt="Generic placeholder image">
          </div>
        </div>

        <div class="container text-left">
            <div class="modal fade" id="team" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h4>Team Table Mapping</h4>
                        </div>
                        <div class="modal-body">
                            <img src="images/dep_team.jpg" style="width: 465px; height: 400px;" alt="team mapping">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <br><br>
      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2020-2021 Company, Inc. &middot; <a href="#">Privacy</a> 
        &middot; <a href="#">Terms</a> &middot; <a href="mailto: usertechsavvy@gmail.com">Contact</a></p>
      </footer>
    </main>

    <!-- Toastr Control Panel -->
    <script src="js_util/toastr.js"></script>

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
