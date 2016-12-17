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
                                    <li>Search Results for {{$searchterm}}
                                    </li>


                                </ul>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-6">

                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-user"></i>Most Tweeted Senators on Social Media in the last 90 days.
                                        </div>


                                    </div>

                                    <div class="portlet-body" id="InfluencerPortlet">

                                        <table class="table table-bordered table-hover dataTable" id="MostPopularTable">
                                            <thead>
                                                <tr>
                                                    <th aria-label="Senator : activate to sort column ascending"
                                                        style="width: 129px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Author</th>
                                                    <th aria-label="Party : activate to sort column ascending"
                                                        style="width: 77px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Senator</th>
                                                    <th aria-label="State : activate to sort column ascending"
                                                        style="width: 72px;" colspan="1" rowspan="1" tabindex="0" class="sorting">State</th>
                                                    <th aria-label="Tweets : activate to sort column ascending"
                                                        style="width: 85px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Views</th>
                                                    <th aria-label="Views : activate to sort column ascending"
                                                        style="width: 85px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Tweet</th>
                                                    <th aria-label="Rank : activate to sort column ascending"
                                                        style="width: 85px;" colspan="1" rowspan="1" tabindex="0" class="sorting">Rank</th>
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



@stop