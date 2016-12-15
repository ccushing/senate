<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8" />
    <title id="PageTitle">United States Senate Social Media Dashboard</title>
    <meta name="description" content="A Dashboard of what people are saying about the United States Senate">
    <meta name="keywords" content="Senate, Social Media, Dashboard">
    <meta name="author" content="Charles Cushing">


    <!--    Bootstrap CSS Files and CSS Plugins -->
    <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/style-responsive.css" rel="stylesheet" type="text/css" />
    <link href="plugins/plugins.css" rel="stylesheet" type="text/css" />
    <link href="plugins/wordcloud.css" rel="stylesheet" type="text/css" />
    <link href="plugins/jqcloud.css" rel="stylesheet" type="text/css" />

    <!--    CSS File for the Site -->
    <link href="css/combined.css" rel="stylesheet" type="text/css" />


</head>



<body class="page-header-fixed">

    <div id="container">


        <div class="header navbar navbar-inverse" id="header">

            <div id="logo">
                <img src="img/logo.png" alt="logo" class="logo" />
            </div>

            <div id="headertitle">
                <h2 id="PageTitleHeader" class="header-title">United States Senate Dashboard
                    <br>
                    <small>A real-time dashboard of all things related to the Unites States Senate.</small>
                </h2>
            </div>


            <div id="topnav">
                <ul class="page-breadcrumb breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Donate</a></li>
                </ul>
            </div>


        </div>

        <div class="clearfix">
        </div>

        <div class="page-container">

            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">

                    <ul class="page-sidebar-menu">

                        <li>
                            <form class="" role="form" action="http://cscie12.dce.harvard.edu/echo" method="post">
                                <div class="searchbox">
                                    <input type="text" class="form-control input-medium" name="SearchTerm" placeholder="Search...">
                                </div>
                            </form>
                        </li>



                        <li class="start active ">
                            <a href="senatedashboard.html">
                                <i class="fa fa-bar-chart-o"></i>
                                <span class="active">Social Media
                                </span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li class="closed">
                            <a href="#" onclick="$('#SenatorsSubMenu').toggle();">
                                <img src="img/open.png" class="nav-img" alt="open" />
                                <span class="title">Senators </span>

                            </a>
                            <ul class="sub-menu" id="SenatorsSubMenu">
                            </ul>
                        </li>



                        <li class="">
                            <a href="mostpopular.html">
                                <i class="fa fa-user"></i>
                                <span class="active">Most Popular Senators
                                </span>
                                <span class="selected"></span>
                            </a>
                        </li>



                        <li class="">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span class="active">Bills
                                </span>
                                <span class="selected"></span>
                            </a>
                        </li>


                        <li class="">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span class="active">Session Schedule
                                </span>
                                <span class="selected"></span>
                            </a>
                        </li>


                    </ul>

                </div>
            </div>


            @yield('page-content')

            <div class="footer">
                2014 &copy; Charles Cushing
            </div>



             <!--    Bootstrap, JQuery, JQCloud, Graph (Flot), Datatables and linq js plugins -->
            <script src="plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
            <script src="plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="plugins/jqcloud-1.0.4.min.js" type="text/javascript"></script>
            <script src="plugins/flot/jquery.flot.js" type="text/javascript"></script>
            <script src="plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
            <script src="plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
            <script src="plugins/linq.js" type="text/javascript"></script>
            <script src="plugins/helper-functions.js" type="text/javascript"></script>


            <!--   Javascript Library for the Site -->
            <script src="js/dashboard-init.js" type="text/javascript"></script>



            <script>
                jQuery(document).ready(function () {

                    InitDashboard();

                });


            </script>


        </div>

    </div>
</body>

</html>

