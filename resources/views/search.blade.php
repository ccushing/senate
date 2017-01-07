@extends('main')

@section('page-content')

 <div class="page-content-wrapper">
                <div class="page-content-wrapper">
                    <div class="page-content">

                        <div class="row">
                            <div class="col-md-12">

                                <h3 id="PageTitleHeader2" class="page-title">Senate Social Media 
                                    <br>
                                    <small>A ranked list of the most tweeted senators.</small>
                                </h3>

                                <ul class="page-breadcrumb breadcrumb">

                                    <li>
                                        <i class="fa fa-home"></i>
                                        <a href="/SenateDashboard">Home

                                        </a>

                                    </li>
                                    <li>Search Results
                                    </li>


                                </ul>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-6">

                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-user"></i>{{ $title }}
                                        </div>


                                    </div>

                                    <div class="portlet-body" id="InfluencerPortlet">

                                    @if(count($tweets)==0)
                                        <h4>No matches found.</h4>
                                    @endif

                                        <table class="table table-bordered table-hover dataTable" id="MostPopularTable">
                                            <thead>
                                                <tr>
                                                    <th aria-label="Senator : activate to sort column ascending"
                                                        style="width: 50px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Author</th>
                                                    <th aria-label="Party : activate to sort column ascending"
                                                        style="width: 150px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Senator</th>
                                                    <th aria-label="State : activate to sort column ascending"
                                                        style="width: 25px;" colspan="1" rowspan="1" tabindex="0" class="sorting">State</th>
                                                    <th aria-label="Party : activate to sort column ascending"
                                                        style="width: 50px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Party</th>
                                                    <th aria-label="Tweets : activate to sort column ascending"
                                                        style="width: 400px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Tweet</th>
                                                    <th aria-label="Views : activate to sort column ascending"
                                                        style="width: 40px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Followers</th>
                                                </tr>
                                            </thead>

                                            <tbody aria-relevant="all" aria-live="polite" role="alert">



                                 @foreach ($tweets as $tweet)

                                                <tr class="@if($tweet->Party=="Republican")
                                                                        rep-bkg
                                                                      @else
                                                                        dem-bkg
                                                                      @endif">
                                                    <td class=" "><a href="https://www.twitter.com/{{ $tweet->UserName }}">{{ $tweet->UserName }}</a></td>
                                                    <td class="  "><a href="/SenatorDashboard/{{ $tweet->SenatorKey }}">{{ $tweet->SenatorName }}</a></td>
                                                    <td class=" ">{{ $tweet->State }}</td>
                                                    <td class=" ">{{ $tweet->Party }}</td>                                                    
                                                    <td class=" ">{{ $tweet->TweetText }}&nbsp;<a href="{{ $tweet->Hyperlink }}" target="_new">(link)</a></td>
                                                    <td class="  sorting_1">{!! number_format ( $tweet->FollowersCount,0 ,"." , ",") !!}</td>




                                                </tr>

                                @endforeach

                                        




                                            </tbody>
                                        </table>

                                {!! $tweets->render() !!}

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
                    InitNavBar();                   
                });





            </script>

@stop