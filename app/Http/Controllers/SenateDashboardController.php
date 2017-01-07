<?php

namespace senate\Http\Controllers;

use senate\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



# Controller for the Senate Dashboard
class SenateDashboardController extends Controller {





    public function getMostPopular(Request $request,$timeframe) {

        if ($timeframe=="")
            $timeframe=1;


        return view('mostpopular', ['message' => "",'timeframe' => $timeframe]);

    }


    public function getSenateDashboard(Request $request) {

        return view('senatedashboard', ['message' => ""]);

    }

    public function getSenatorDashboard(Request $request,$senator_id) {

        return view('senatordashboard', ['senator_id' => $senator_id]);

    }


    public function getTrending(Request $request,$timeframe) {

        if ($timeframe=="")
            $timeframe=1;

        return view('trending', ['message' => "",'timeframe' => $timeframe,'activelink' => 'TrendingLink']);

    }

    public function getAbout(Request $request) {

        return view('about', ['message' => ""]);

    }


    public function getFAQ(Request $request) {

        return view('FAQ', ['message' => ""]);

    }


    public function getHome(Request $request) {

        return view('senatedashboard', ['message' => ""]);

    }


    public function getDonate(Request $request) {

        return view('donate', ['message' => ""]);

    }


    public function getSearch(Request $request,$searchterm) {

        $items = $this->search($searchterm);

        # Pagination needs to be done manually with raw SQL queries
        $page = $request->input('page', 1); 
        $tweets = $this->setupPagination($items,$page,100);

        return view('search', ['title' => "Search Results for \"".$searchterm."\"",'tweets' => $tweets]);
    

    }

    public function postSearch(Request $request) {


        $searchTerm = $request->input("search-term");
        $items = $this->search($searchterm);

        # Pagination needs to be done manually with raw SQL queries
        $page = $request->input('page', 1); 
        $tweets = $this->setupPagination($items,$page,100);

        return view('search', ['title' => "Search Results for \"".$searchTerm."\"",'tweets' => $tweets]);
    

    }


    public function search($searchterm)
    {

            $sql = "SELECT 
                    TwitterFeedKey,
                    DateCreated,
                    SenatorKey,
                    SenatorName,
                    PicURL,
                    Party,
                    TermExpiration,
                    State,
                    StateName,
                    TweetID,
                    TweetText,
                    Hyperlink,
                    UserKey,
                    RetweetCount,
                    FavoriteCount,
                    BatchKey,
                    TweetScore,
                    UserName,
                    Description,
                    ScreenName,
                    UserID,
                    Location,
                    FollowersCount,
                    FriendsCount,
                    ListedCount
                    FROM 
                    vw_tweet
                    WHERE
                    TweetText LIKE '%" . $searchterm . "%' ORDER BY FollowersCount DESC LIMIT 100";

            $items = \DB::select(\DB::raw($sql));

            return $items;

    }


    public function postSearchUser(Request $request,$userid) {

        return view('search', ['userid' => $userid]);

    }


    public function setupPagination($items,$page,$pageSize){
  
        $offSet = ($page * $pageSize) - $pageSize; 

        # Get only the items you need using array_slice
        $thispage = array_slice($items, $offSet, $pageSize, true);

        $tweets = new \Illuminate\Pagination\LengthAwarePaginator($thispage, count($items), $pageSize, $page);


        return $tweets;
    }




}