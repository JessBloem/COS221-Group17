<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Example</title>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/header.css">
    <meta charset="utf-8">
</head>


<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img id="companyLogo" src="img/companyLogo.png" alt="" style="width:50px;">
                    <label id="companyName" for="companyLogo">GWS</label>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="nav navbar-dark bg-dark nav-pills nav-fill gap-2 p-1 small bg-secondary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-gray-100);">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active rounded-5" href="index.php" type="button" data-bs-toggle="tab" role="tab" aria-selected="true">Wines</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  rounded-5" href="winery.php" type="button" data-bs-toggle="tab" role="tab" aria-selected="false">Wineries</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  rounded-5" href="suggestions.php" type="button" data-bs-toggle="tab" role="tab" aria-selected="false">Suggestions</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  rounded-5" href="" type="button" data-bs-toggle="tab" role="tab" aria-selected="false">Contact Us</a>
                        </li>
                        <li class="nav-item signupLogin" role="presentation">
                            <a class="nav-link  rounded-5" href="" type="button" role="tab" aria-selected="false">Login</a>
                        </li>
                        <li class="nav-item signupLogin" role="presentation">
                            <a class="nav-link  rounded-5" href="" type="button" role="tab" aria-selected="false">Signup</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="d-flex searchBarDiv">
            <input class="form-control me-2" type="text" placeholder="Search">
            <button class="btn btn-primary" type="button">Search</button>
        </div>
    </header>

    <script src="css/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>


</html>