<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8" />
    <title id="PageTitle">United States Senate Social Media Dashboard</title>
    <meta name="description" content="A Dashboard what peple are saying about the Senate on Twitter">
    <meta name="keywords" content="Senate, Twitter, Dashboard">
    <meta name="author" content="Charles Cushing">


    <!--    Bootstrap CSS Files and CSS Plugins -->
    <link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/style-responsive.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/wordcloud.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/jqcloud.css" rel="stylesheet" type="text/css" />

    <!--    CSS File for the Site -->
    <link href="/css/combined.css" rel="stylesheet" type="text/css" />


</head>



<body class="page-header-fixed">

    <div id="container">


        <div class="header navbar navbar-inverse" id="header">

            <div id="logo">
                <img src="/img/logo.png" alt="logo" class="logo" />
            </div>

            <div id="headertitle">
                <h2 id="PageTitleHeader" class="header-title">United States Senate Dashboard
                    <br>
                    <small>A Dashboard what peple are saying about the Senate on Twitter.</small>
                </h2>
            </div>


            <div id="topnav">
                <ul class="page-breadcrumb breadcrumb">
                    <li><a href="/Home">Home</a></li>
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
                            <form class="" role="form" action="/Search" method="post">
                            {{ csrf_field() }}
                                <div class="searchbox">
                                    <input type="text" class="form-control input-medium" name="search-term" id="search-term" placeholder="Search...">
                                </div>
                            </form>
                        </li>



                        <li id="SocialMediaLink" class="start">
                            <a href="/SenateDashboard">
                                <i class="fa fa-bar-chart-o"></i>
                                <span class="active">Senate Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li id="MostPopularLink" class="">
                            <a href="/MostPopular/1">
                                <i class="fa fa-user"></i>
                                <span class="active">Most Popular Senators</span>
                                <span class="selected"></span>
                            </a>
                        </li>



                        <li id="TrendingLink" class="">
                            <a href="/Trending/2">
                                <i class="fa fa-user"></i>
                                <span class="active">Trending</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li id="SenatorsLink" class="closed">
                            <a href="#" onclick="$('#SenatorsSubMenu').toggle();">
                                <img src="/img/open.png" class="nav-img" alt="open" />
                                <span class="title">Senators </span>

                            </a>
                            <ul class="sub-menu" id="SenatorsSubMenu" style="display: block;">
                            </ul>
                        </li>


                    </ul>

                </div>
            </div>


            @yield('page-content')




        </div>

    </div>
</body>

</html>

