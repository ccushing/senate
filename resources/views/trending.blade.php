@extends('main')

@section('page-content')

 <div class="page-content-wrapper">
                <div class="page-content-wrapper">
                    <div class="page-content">

                        <div class="row">
                            <div class="col-md-12">

                                <h3 id="PageTitleHeader2" class="page-title">Senate Social Media 
                                    <br>
                                    <small>Trending words related to the United States Senate.</small>
                                </h3>

                                <ul class="page-breadcrumb breadcrumb">

                                    <li>
                                        <i class="fa fa-home"></i>
                                        <a href="/SenateDashboard">Home</a>
                                    </li>
                                    <li>Trending Words
                                    </li>


                                </ul>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-6">

                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-user"></i>Trending Words.
                                        </div>


                                    </div>

                                    <div class="portlet-body" id="InfluencerPortlet">
                                    <p>
                                      <button type="button" id="btn-timeframe1" onclick="location.href='/Trending/1';" class="btn btn-default btn-lg">Last Day</button>
                                      <button type="button" id="btn-timeframe2" onclick="location.href='/Trending/2';" class="btn btn-default btn-lg">Last Week</button>
                                      <button type="button" id="btn-timeframe3" onclick="location.href='/Trending/3';" class="btn btn-default btn-lg">Last 30 Days</button>
                                      <button type="button" id="btn-timeframe4" onclick="location.href='/Trending/4';" class="btn btn-default btn-lg">Last 90 Days</button>
                                    </p>

                                        <table class="table table-bordered table-hover dataTable" id="TrendingWordsTable">
                                            <thead>
                                                <tr>
                                                    <th aria-label="Senator : activate to sort column ascending"
                                                        style="width: 100px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Word</th>
                                                    <th aria-label="Party : activate to sort column ascending"
                                                        style="width: 50px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Count</th>
                                                    <th aria-label="Party : activate to sort column ascending"
                                                        style="width: 50px;" colspan="1" rowspan="1" tabindex="0" class="sorting">% Change</th>
                                                </tr>
                                            </thead>

                                            <tbody aria-relevant="all" aria-live="polite" role="alert">
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="footer">
                2014 &copy; Charles Cushing
            </div>

            <!--    Bootstrap, JQuery, JQCloud, Graph (Flot), Datatables and linq js plugins -->
            <script src="/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
            <script src="/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="/plugins/jqcloud-1.0.4.min.js" type="text/javascript"></script>
            <script src="/plugins/flot/jquery.flot.js" type="text/javascript"></script>
            <script src="/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
            <script src="/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
            <script src="/plugins/linq.js" type="text/javascript"></script>
            <script src="/plugins/helper-functions.js" type="text/javascript"></script>

            <!--   Javascript Library for the Site -->
            <script src="/js/dashboard-init.js" type="text/javascript"></script>
            <script>
                jQuery(document).ready(function () {


                    timeframe = {{$timeframe}};
                    // Change the highlighted button
                    $('#btn-timeframe' + timeframe).addClass('btn-primary');


                    InitTrending(timeframe);

                });





            </script>

@stop