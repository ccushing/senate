@extends('main')

@section('page-content')

 <div class="page-content-wrapper">
                <div class="page-content-wrapper">
                    <div class="page-content">


                        <div class="row">
                            <div class="col-md-12">

                                <h3 id="PageTitleHeader2" class="page-title">Senate Social Media 
                                    <br>
                                    <small>A real-time dashboard of what people are saying about the Unites States Senate on Twitter in the past week.</small>
                                </h3>

                                <ul class="page-breadcrumb breadcrumb">

                                    <li>
                                        <i class="fa fa-home"></i>
                                        <a href="senatedashboard.html">Home

                                        </a>

                                    </li>
                                    <li>Senators
                                    </li>
                                    <li id="SenatorBreadCrumb"></li>


                                </ul>


                            </div>
                        </div>


                        <div class="clearfix">
                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-4">
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-bar-chart"></i>Senator Bio
                                        </div>
                                        <div class="tools">
                                            <a class="collapse" href="#" onclick="$('#BioPortlet').toggle();"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body" id="BioPortlet">
                                        <div class="top-news">

                                            <a href="#" class="btn" id="PartyBG">
                                                <h3 id="SenatorName">Sen</h3>
                                                <img id="SenatorPIC" src="senatepics/blank.png" height="165" alt="senator">

                                                <em id="SenatorParty">Party : </em>
                                                <em id="SenatorState">State : </em>
                                                <em id="SenatorClass">Class : </em>
                                                <em id="SenatorTermExpires">Term Expires : </em>
                                                <div class="clearfix"></div>
                                            </a>

                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-sm-4">

                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-bar-chart"></i>Twitter Activity
                                        </div>
                                        <div class="tools">
                                            <a class="collapse" href="#" onclick="$('#GraphPortlet').toggle();"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body" id="GraphPortlet">
                                        <div id="site_statistics_loading">
                                            <img src="img/loading.gif" alt="loading" />
                                        </div>
                                        <div id="site_statistics_content" class="display-none">
                                            <div id="site_statistics" class="chart">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>


                        <div class="clearfix">
                        </div>


                        <div class="row ">

                            <div class="col-md-6 col-sm-6">
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-user"></i>Trending Words
                                        </div>
                                        <div class="tools">
                                            <a class="collapse" href="#WordPortlet" onclick="$('#WordPortlet').toggle();"></a>
                                        </div>

                                    </div>
                                    <div class="portlet-body" id="WordPortlet">

                                        <div style="width: 600px; height: 500px;" class="jqcloud" id="wordcloud">
                                        </div>

                                    </div>
                                </div>



                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-user"></i>Influencers
                                        </div>
                                        <div class="tools">
                                            <a class="collapse" href="#" onclick="$('#InfluencerPortlet').toggle();"></a>
                                        </div>

                                    </div>

                                    <div class="portlet-body" id="InfluencerPortlet">

                                            <table class="table table-striped table-bordered table-hover dataTable" id="influencersTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 11px;" colspan="1" rowspan="1" tabindex="0" class="sorting_desc"></th>
                                                        <th style="width: 129px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Username</th>
                                                        <th style="width: 77px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Tweets</th>
                                                        <th style="width: 72px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Followers</th>
                                                        <th style="width: 85px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Influence</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                </tbody>
                                            </table>

                                    </div>
                                </div>


                            </div>


                            <div class="col-md-6 col-sm-6">

                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-user"></i>Top Tweets Over the Past Week
                                        </div>
                                        <div class="tools">
                                            <a class="collapse" href="#" onclick="$('#TweetsPortlet').toggle();"></a>
                                        </div>

                                    </div>

                                    <div class="portlet-body" id="TweetsPortlet">


                                        <table id="tweetsTable">

                                            <thead>
                                                <tr>
                                                    <th>Tweets</th>
                                                    <th></th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>



                            <div class="clearfix">
                            </div>

                        </div>


                        <div class="clearfix">
                        </div>
                    </div>
                </div>

            </div>



@stop