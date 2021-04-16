<?php
require_once ("Controllers/authControllers.php");
require_once ("js_util/component.php");
require_once ("Controllers/userProfileControllers.php");
require_once ("Controllers/convControllers.php");

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

    <title>Conversations</title>

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
            <!--<?php if (isset ($_SESSION['id'])): ?>
                <a class="btn btn-info" href="homepage.php?logout=1"><i class="fa fa-sign-out-alt"></i> Log Out</a>
            <?php endif; ?>-->
            <?php if (isset ($_SESSION['id'])): ?>
                <a class="btn btn-outline-dark" data-toggle="modal" data-target="#menu" href="#"><span style="color: white;"><!-- <i class="fa fa-user-circle fa-lg"></i> -->
                        <img class="rounded-circle" src=<?php echo (getImage ()); ?> alt="Generic placeholder image" width="30" height="30">
                        <span style="color: darkorange;"><?php echo (getName ()); ?></span></span></a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main role="main">

    <div class="container text-left">
        <div class="modal fade" id="menu" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-body">
                        <div class="list-group">
                            <a class="btn btn-outline-light" href="profile.php"><i class="fa fa-user" style="color: coral;"></i> Profile</a>
                            <br>
                            <a class="btn btn-outline-light" href="conversations.php"><i class="fa fa-comment" style="color: red;"></i><sup>1</sup> Conversations</a>
                            <a class="btn btn-outline-light" href="conversations.php?conversation=none&invitation=1"><i class="fas fa-sticky-note" style="color: darkorange;"></i><sup>1</sup> Invitations</a>
                            <br>
                            <a class="btn btn-outline-light" href="homepage.php?logout=1"><i class="fa fa-sign-out-alt" style="color: deepskyblue;"></i> Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <div class="row">

            <div class="col container text-center">
                <br><br>
                <h1 class="py-4 bg-dark text-light rounded"><i style="color: orange;" class="fab fa-apple fa-lg"></i>
                    <?php if (!isset ($_GET['conversation'])): ?>
                    Conversations
                    <?php endif; ?>

                    <?php if (isset ($_GET['conversation']) and $_GET['conversation'] != 'none'): ?>
                        Invitations for conversation <?php echo ($_GET['conversation']); ?>
                    <?php endif; ?>

                    <?php if (isset ($_GET['invitation'])): ?>
                        My invitations
                    <?php endif; ?>
                </h1>

                <br><br><br><br>
                <?php if (!isset ($_GET['conversation'])): ?>
                    <div class="d-flex table-data wide2">
                        <table class="table table-dark table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Author</th>
                                <th>Members</th>
                                <th>Invitations</th>
                                <th>Messages</th>
                            </tr>
                            </thead>

                            <tbody id="tbody">
                            <?php $result = getDataConv ($_SESSION['id']);

                            if ($result->num_rows) {
                                while ($row = $result->fetch_assoc ()) { ?>

                                    <tr>
                                        <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['id']); ?></td>
                                        <td><?php echo ($row['time']); ?></td>
                                        <td><img class="rounded-circle" src=<?php echo (getImageByID ($_SESSION['id'])); ?> alt="Generic placeholder image" width="30" height="30"></td>
                                        <td>
                                            <?php $result1 = getDataInv ($row['id']);

                                            if ($result1->num_rows > 0) {
                                                while ($row1 = $result1->fetch_assoc ()) { ?>
                                                    <img class="rounded-circle" src=<?php echo (getImageByID ($row1['usr_to'])); ?> alt="Generic placeholder image" width="30" height="30">
                                                <?php }
                                            } else echo ('No members yet'); ?>
                                        </td>
                                        <td><a href="conversations.php?conversation=<?php echo ($row['id']); ?>"><i class="fa fa-link" style="color: tomato;"></i></a></td>
                                        <td><a href="conversations.php?conversation=none&messages=<?php echo ($row['id']); ?>"><i class="fa fa-comment-dots" style="color: deepskyblue;"></i></a></td>
                                    </tr>

                                    <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6">No conversations available</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if (isset ($_GET['conversation']) and $_GET['conversation'] != 'none'): ?>
                    <div class="d-flex table-data wide2">
                        <table class="table table-dark table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Receiver</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                            </thead>

                            <tbody id="tbody">
                            <?php $result = getDataInvAll ($_GET['conversation']);

                            if ($result->num_rows) {
                                while ($row = $result->fetch_assoc ()) { ?>

                                    <tr>
                                        <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['id']); ?></td>
                                        <td>
                                            <img class="rounded-circle" src=<?php echo (getImageByID ($row['usr_to'])); ?> alt="Generic placeholder image" width="30" height="30">
                                            <?php echo (getNameByID ($row['usr_to'])); ?>
                                        </td>
                                        <td>
                                            <?php
                                                $col = 'orange';
                                                if ($row['status'] == 'acc')
                                                    $col = 'green';
                                                else if ($row['status'] == 'refused')
                                                    $col = 'red';
                                            ?>
                                            <span style="color: <?php echo ($col); ?>">
                                            <?php echo ($row['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo ($row['time']); ?></td>
                                    </tr>

                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="5">No invitations to be shown</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if (isset ($_GET['invitation'])): ?>
                    <div class="d-flex table-data wide2">
                        <table class="table table-dark table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody id="tbody">
                            <?php $result = getDataInvAllForUser ($_SESSION['id']);

                            if ($result->num_rows) {
                                while ($row = $result->fetch_assoc ()) { ?>

                                    <tr>
                                        <td data-id="<?php echo ($row['id']); ?>"><?php echo ($row['id']); ?></td>
                                        <td>
                                            <img class="rounded-circle" src=<?php echo (getImageByID ($row['usr_from'])); ?> alt="Generic placeholder image" width="30" height="30">
                                            <?php echo (getNameByID ($row['usr_from'])); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $col = 'orange';
                                            if ($row['status'] == 'acc')
                                                $col = 'green';
                                            else if ($row['status'] == 'refused')
                                                $col = 'red';
                                            ?>
                                            <span style="color: <?php echo ($col); ?>">
                                                <?php echo ($row['status']); ?>
                                                </span>
                                        </td>
                                        <td><?php echo ($row['time']); ?></td>
                                        <td data-id="<?php echo ($row['id']); ?>"><i class="fa fa-user-edit btnedit" style="color: coral;"></i></td>
                                    </tr>

                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="5">No invitations to be shown</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col">
                <br><br>

                <div class="text-center">
                    <img class="rounded-circle" src=<?php echo (getImage ()); ?> alt="Generic placeholder image" width="310" height="310">
                    <h2><span style="color: orange;"><?php echo (getName ()); ?></span></h2>

                    <br><br>
                    <div class="d-flex justify-content-center">
                        <?php if (!isset ($_GET['conversation'])): ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="py-2">
                                    <?php inputElement ('<i class="fas fa-file-signature fa-lg"></i>', 'Conversation ID', 'conv_id', setIdConv ()); ?>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <?php buttonElement ('btn-create', 'btn btn-primary', '<i class= "fa fa-plus fa-lg"></i> Create conversation', 'create-conv', 'data-toggle="tooltip" data-placement="bottom" title="Create"'); ?>
                                </div>
                            </form>
                        <?php endif; ?>
                        <?php if (isset ($_GET['conversation']) and $_GET['conversation'] != 'none'): ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="py-2">
                                    <?php inputElement ('<i class="fas fa-file-signature fa-lg"></i>', 'Invitation ID', 'inv_id', setIdInv ()); ?>
                                </div>

                                <div class="py-2">
                                    <?php inputElement ('<i class="fas fa-envelope fa-lg"></i>', 'Receiver email', 'user_email', ''); ?>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <?php buttonElement ('btn-create', 'btn btn-primary', '<i class= "fa fa-plus fa-lg"></i> Send invitation', 'create-inv', 'data-toggle="tooltip" data-placement="bottom" title="Create"'); ?>
                                </div>
                            </form>
                        <?php endif;?>
                        <?php if (isset ($_GET['invitation'])): ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="py-2">
                                    <?php inputElement ('<i class="fas fa-file-signature fa-lg"></i>', 'Invitation ID', 'inv_id', setIdInvMine ()); ?>
                                </div>

                                <div class="py-2">
                                    <?php inputElement ('<i class="fas fa-check-circle fa-lg"></i>', 'Invitation status', 'inv_status', ''); ?>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <?php buttonElement ('btn-create', 'btn btn-primary', '<i class= "fa fa-plus fa-lg"></i> Send invitation', 'create-inv', 'data-toggle="tooltip" data-placement="bottom" title="Create"'); ?>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- /.col-lg-4 -->

        </div><!-- /.row -->

    </div><!-- /.container -->


    <!-- FOOTER -->
    <br><br>
    <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2020-2021 Company, Inc. &middot; <a href="#">Privacy</a>
            &middot; <a href="#">Terms</a> &middot; <a href="mailto: usertechsavvy@gmail.com">Contact</a></p>
    </footer>
</main>

<!-- Toastr Control Panel -->
<script src="js_util/toastr.js"></script>

<script>
    let id = $('input[name*="conv_id"]');
    id.attr ('readonly', 'readonly');

    let id_inv = $('input[name*="inv_id"]');
    id_inv.attr ('readonly', 'readonly');

    $('.btnedit').click (e => {
        let textvalues = displayData (e);
        console.log (textvalues);

        let user_admin = $('input[name*="user_admin"]');
        let user_name = $('input[name*="user_name"]');
        let user_bios = $('textarea[name*="user_bios"]');

        id.val (textvalues[0]);
        user_admin.val (textvalues[2]);
        user_name.val (textvalues[1]);
        user_bios.val (textvalues[3]);
    });

    $('.btndel').click (e => {
        let textvalues = displayData (e);

        id.val (textvalues[0]);
    });

    function displayData (e) {
        let id = 0;
        const td = $('#tbody tr td');
        let textvalues = [];

        for (const value of td) {
            if (value.dataset.id == e.target.dataset.id) {
                textvalues[id ++] = value.textContent;
            }
        }

        return textvalues;
    }
</script>

<?php if (isset ($_SESSION['login'])) {
    unset ($_SESSION['login']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('You are logged in...');
              });
      </script>
    "); } ?>

<?php if (isset ($_SESSION['conv-done'])) {
    unset ($_SESSION['conv-done']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('Conversation created successfully');
              });
      </script>
    "); } ?>

<?php if (isset ($_SESSION['no-email'])) {
    unset ($_SESSION['no-email']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Email address is required');
              });
      </script>
    "); } ?>

<?php if (isset ($_SESSION['no-user-inDB'])) {
    unset ($_SESSION['no-user-inDB']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('No user with specified email in DB');
              });
      </script>
    "); } ?>

<?php if (isset ($_SESSION['conv-fail'])) {
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('" . $_SESSION['conv-fail'] . "');
              });
      </script>
    ");
    unset ($_SESSION['conv-fail']);} ?>

<?php if (isset ($_SESSION['inv-done'])) {
    echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('Invitation created successfully');
              });
      </script>
    ");
    unset ($_SESSION['inv-done']);} ?>

<?php if (isset ($_SESSION['inv-fail'])) {
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('Invitation couldn\'t be created');
              });
      </script>
    ");
    unset ($_SESSION['inv-fail']);} ?>

<?php if (isset ($_SESSION['already-inv-for-usr-conv'])) {
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('An invitation for this current conversation and the specified user has already been sent');
              });
      </script>
    ");
    unset ($_SESSION['already-inv-for-usr-conv']);} ?>

<?php if (isset ($_SESSION['upd-done'])) {
    echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('User profile successfully updated!');
              });
      </script>
    ");
    unset ($_SESSION['upd-done']);
} ?>

<?php if (isset ($_SESSION['upd-fail'])) {
    unset ($_SESSION['upd-fail']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('User profile updating failed!');
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

<?php if (isset ($_SESSION['no-upd'])) {
    unset ($_SESSION['no-upd']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('There is nothing to update');
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

<?php if (isset ($_SESSION['refreshed'])) {
    unset ($_SESSION['refreshed']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.info ('Users table has been refreshed');
              });
      </script>
    ");} ?>

<?php if (isset ($_SESSION['deleted'])) {
    unset ($_SESSION['deleted']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.success ('User has been deleted successfully');
              });
      </script>
    ");} ?>

<?php if (isset ($_SESSION['dfail'])) {
    unset ($_SESSION['dfail']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('User deletion failed');
              });
      </script>
    ");} ?>

<?php if (isset ($_SESSION['denied-perm'])) {
    unset ($_SESSION['denied-perm']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('You cannot delete another admin\'s account unless you are a super admin');
              });
      </script>
    ");} ?>

<?php if (isset ($_SESSION['no-del'])) {
    unset ($_SESSION['no-del']);
    echo ("
      <script>
              $(document).ready (function () {
                toastr.error ('There is nothing to delete');
              });
      </script>
    ");} ?>

</body>
</html>
