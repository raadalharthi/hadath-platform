<?php
$activeContactUsPage;
$activeLoginPage;
$activeOrganizerSignupPage;
$activeCart;

switch ($title)
    {
        case "Contact Us":
            $activeContactUs = "active";
        break;

        case "Login":
            $activeLoginPage = "active";
        break;

        case "Organizer Signup":
            $activeOrganizerSignupPage = "active";
        break;

        case "Cart":
            $activeCart = "active";
        break;

        case "Past Purchase":
            $activePS = "active";
        break;

    }

    session_start();

    if (empty($_SESSION['cartID']))
    {
        $cartQuantity = 0;
    }

    else {
    $cartQuantity = count($_SESSION['cartID']);
    }


?>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ebebeb">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="assets\logo.svg" alt="" width="75" /></a>
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (empty($_SESSION['organizerID']) == false) {}

                else { ?>

                <?php if (empty($_SESSION['attendeeID']) == false) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?= $activePS ?>" href="pastPurchase.php">Past Purchase</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activeContactUs ?>" href="contactUs.php">Contact Us</a>
                </li>

                <?php
                } else { ?>
                <li class="nav-item">
                    <a class="nav-link <?= $activeContactUs ?>" href="contactUs.php">Contact Us</a>
                </li>
                <?php }
                }?>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= $activeLoginPage ?>" href="guestLoginPage.php">
                        <span><i class="fa-solid fa-user"></i></span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
            <?php if (empty($_SESSION['organizerID']) == false) {}

            else {?>
                <li class="nav-item">
                    <a class="nav-link <?= $activeCart ?>" href="cart.php">
                        <span><i class="fas fa-shopping-cart"></i></span>
                        <span class="badge badge-pill bg-danger"><?php echo $cartQuantity; ?></span>
            <?php }?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>