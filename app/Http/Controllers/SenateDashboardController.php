<?php

namespace senate\Http\Controllers;

use senate\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



# Controller for the Senate Dashboard
class SenateDashboardController extends Controller {





    public function getMostPopular(Request $request) {

        return view('mostpopular', ['message' => ""]);

    }


    public function getSenateDashboard(Request $request) {

        return view('senatedashboard', ['message' => ""]);

    }

    public function getSenatorDashboard(Request $request,$senator_id) {

        return view('senatordashboard', ['senator_id' => $senator_id]);

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


}