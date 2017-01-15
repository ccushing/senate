
// Javascript Library for Sentate Social Media Dashboard
// Written By : Charles Cushing
// CSCI E 12 : Final Project

// Functions which load data from .json files and bind them to elements within the page

// Function Called by senatedashboard.html which will bind data from .json files to the dashboard
function InitDashboard() {

    // Populate Elements in the Main Dashboard
    var dashboardData = LoadDashboardData();
    BindDashboard(dashboardData);

    // Populate the Senator Sub-Nav from .json file
    var senatorNavData = LoadMostPopularData(2);
    BindSenatorsNavBar(senatorNavData);

    $('#SocialMediaLink').addClass("active");
}

// Function used by mostpopular.html to bind .json data to the page
function InitMostPopular(timeframe) {

    // Populate the Senator Sub-Nav from .json file
    var senatorNavData = LoadMostPopularData(timeframe);

    // Bind Json data to most popular data table
    BindMostPopular(senatorNavData);

    BindSenatorsNavBar(senatorNavData);

    $('#MostPopularLink').addClass("active");

}


// Function used by mostpopular.html to bind .json data to the page
function InitTrending(timeframe) {

    // Populate the Senator Sub-Nav from .json file
    var senatorNavData = LoadMostPopularData(timeframe);
    BindSenatorsNavBar(senatorNavData);


    // Bind Json data to most popular data table
    trendingData = LoadTrendingData(timeframe);
    BindTrending(trendingData);

    $('#TrendingLink').addClass("active");

    //alert(window.location.href);

}



function InitNavBar() {

    var senatorNavData = LoadMostPopularData(3);
    BindSenatorsNavBar(senatorNavData);


}


// Function Called by senatordashboard.html which will bind data from .json files to the dashboard
// This page expects a valid SenatorKey value to be passed into the page's query string
function InitSenatorDashboard(SenatorKey) {

    // Populate the Senator Sub-Nav from .json file
    var senatorNavData = LoadMostPopularData(2);
    BindSenatorsNavBar(senatorNavData);

    // Populate Elements in the Main Dashboard
    var senatorDashboardData = LoadSenatorData(SenatorKey);
    BindSenatorDashboard(senatorDashboardData);

    $('#SenatorsLink').addClass("active");

}

// Binds each element in the senate dashboard from .json data file
function BindDashboard(dashboardData) {

    BindGraph(dashboardData.DashboardGraph);
    BindWordsTable(dashboardData.DashboardWords);
    BindInfluencerTable(dashboardData.DashboardInfluencers);
    BindTweetsTable(dashboardData.DashboardTweets);

}

// Binds each element in the senator dashboard from .json data file
function BindSenatorDashboard(SenatorDashboardData) {
    BindSenatorBio(SenatorDashboardData);
    BindSenatorGraph(SenatorDashboardData);
    BindWordsTable(SenatorDashboardData.DashboardWords);
    BindInfluencerTable(SenatorDashboardData.DashboardInfluencers);
    BindSenatorTweetsTable(SenatorDashboardData.DashboardTweets);
}


function BindSenatorBio(SenatorDashboardData) {


    // Load the Image
    $("#SenatorPIC")[0].src = '/senatepics/Senate_' + SenatorDashboardData.SenatorKey + '.png';
    $("#SenatorPIC")[0].title = 'Source : Wikipedia.org';

    if (SenatorDashboardData.SenatorParty == "Democratic") {
        $('#PartyBG').addClass('btn-info');
    }
    else {
        $('#PartyBG').addClass('btn-danger');
    }

    // Open the Sub-Menu & Highlight the Selected Senator
    //$('#SenatorsSubMenu').toggle();
    $('#senator_' + SenatorDashboardData.SenatorKey).addClass('active-item');

    // Fill in the Bio Info
    $("#SenatorName")[0].innerHTML = SenatorDashboardData.SenatorName;
    $("#SenatorParty")[0].innerHTML = "Party : " + SenatorDashboardData.SenatorParty;
    $("#SenatorState")[0].innerHTML = "State : " + SenatorDashboardData.SenatorState;
    $("#SenatorClass")[0].innerHTML = "Class : " + SenatorDashboardData.SenatorClass;
    $("#SenatorTermExpires")[0].innerHTML = "Term Expires : " + SenatorDashboardData.SenateTermExpireString.substring(0, 8);

    // Put the Senator's Name in the Breadcrumb Trail
    $("#SenatorBreadCrumb")[0].innerHTML = SenatorDashboardData.SenatorName;

    

}

function BindSenatorGraph(SenatorDashboardData) {

    // Set up the graph dashboard
    var graphData = SenatorDashboardData.DashboardGraph;

    graphData.forEach(function (item) { item.Date = dateFormat(item.Date, "mm/dd/yy"); });


    var xaxisdata = Enumerable.From(graphData).Select("x => [x['OrderNum'],x['Date']]").Distinct().ToArray();
    var senator1 = Enumerable.From(graphData).Select("x => [x['OrderNum'],x['TweetScore']]").ToArray();

    var lineColor = [];

    if (SenatorDashboardData.Party == "Democratic")
        lineColor.push("#37b7f3");

    if (SenatorDashboardData.Party == "Republican")
        lineColor.push("#d12610");


    function showTooltip(x, y, item) {

        var dataItem;

        dataItem = Enumerable.From(graphData).ToArray()[item.dataIndex];




        $('<div id="tooltip" class="chart-tooltip"><h4><b>' + dataItem.UserName + '</b></h4><h6>' + dataItem.DateCreated + '</h6><span class="badge badge-' + ((SenatorDashboardData.SenatorParty == "Republican") ? "important" : "info") + '"> ' + SenatorDashboardData.SenatorParty.substring(0, 1).toUpperCase() + '-' + dataItem.State.toUpperCase() + '</span> ' + dataItem.SenatorName + '<hr><p>' + dataItem.TweetText + '</p></div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 100,
            width: 220,
            left: x - 250,
            opacity: .80,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#333',
        }).appendTo("body").fadeIn(200);
    }


    if ($('#site_statistics').size() != 0) {

        $('#site_statistics_loading').hide();
        $('#site_statistics_content').show();

        var plot_statistics = $.plot($("#site_statistics"), [{
            data: senator1,
            label: "Tweet Score"
        }],
        {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.05
                        }, {
                            opacity: 0.01
                        }
                        ]
                    }
                },
                points: {
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderWidth: 0
            },
            colors: lineColor,
            xaxis: { ticks: xaxisdata },
            yaxis: {
                ticks: 11,
                tickDecimals: 0
            }
        });

        var previousPoint = null;
        $("#site_statistics").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showTooltip(item.pageX, item.pageY, item);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });

        $("#site_statistics").bind("plotclick", function (event, pos, item) {

            var dataItem;
            if (item) {
                dataItem = Enumerable.From(graphData).ToArray()[item.dataIndex];

                if (dataItem.Link)
                    window.open(dataItem.Link);
            }
        });
    }


}

function LoadDashboardData() {
    // Load Dashboard Data from .json data file into the dashboardData variable

    var url = "/data/CongressDashboard_2.json";
    var dashboardData;
    var timeFrameName = "";

    $.ajax({
        'async': false,
        'global': false,
        'url': url,
        'dataType': "json",
        'timeout': 20000,
        'success': function (data) {
            dashboardData = data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }

    });

    return dashboardData;
}

function LoadMostPopularData(timeframe)
    {
    // Load Dashboard Data from .json data file into the dashboardData variable
    
        var url = "/data/mostpopular_" + timeframe + ".json";
        var mostPopularData;

    $.ajax({
        'async': false,
        'global': false,
        'url': url,
        'dataType': "json",
        'timeout': 20000,
        'success': function (data) {
            mostPopularData = data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }

    });

    return mostPopularData;
}


function LoadTrendingData(timeframe)
    {
    // Load Dashboard Data from .json data file into the dashboardData variable
    
        var url = "/data/trending_" + timeframe + ".json";
        var trendingData;

    $.ajax({
        'async': false,
        'global': false,
        'url': url,
        'dataType': "json",
        'timeout': 20000,
        'success': function (data) {
            trendingData = data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }

    });

    return trendingData;
}


function LoadSenatorData(SenatorKey)
{
    var url = '/data/senators/SenatorDashboard_' + SenatorKey + '_2.json';
    var senatorDashboardData;


    $.ajax({
        'async': false,
        'global': false,
        'url': url,
        'dataType': "json",
        'timeout': 20000,
        'success': function (data) {
            senatorDashboardData = data;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }

    });

    return senatorDashboardData;
}

function BindGraph(GraphData) {


    GraphData.forEach(function (item) { item.Date = dateFormat(item.Date, "mm/dd/yy"); });


    var xaxisdata = Enumerable.From(GraphData).Select("x => [x['OrderNum'],x['Date']]").Distinct().ToArray();

    var republicans = Enumerable.From(GraphData).Where("x => x.Party == 'Republican'").Select("x => [x['OrderNum'],x['TweetScore']]").ToArray();
    var democrats = Enumerable.From(GraphData).Where("x => x.Party == 'Democratic'").Select("x => [x['OrderNum'], x['TweetScore']]").ToArray();



    function showTooltip(x, y, item) {

        var dataItem;

        if (item.seriesIndex == 0)
            dataItem = Enumerable.From(GraphData).Where("x => x.Party == 'Republican'").ToArray()[item.dataIndex];

        if (item.seriesIndex == 1)
            dataItem = Enumerable.From(GraphData).Where("x => x.Party == 'Democratic'").ToArray()[item.dataIndex];


        $('<div id="tooltip" class="chart-tooltip"><h4><b>' + dataItem.UserName + '</b></h4><h6>' + dataItem.DateCreated + '</h6><span class="badge badge-' + ((dataItem.Party == "Republican") ? "important" : "info") + '"> ' + dataItem.Party.substring(0, 1).toUpperCase() + '-' + dataItem.State.toUpperCase() + '</span> ' + dataItem.SenatorName + '<hr><p>' + dataItem.TweetText + '</p></div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 100,
            width: 220,
            left: x - 250,
            opacity: .80,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#333',
        }).appendTo("body").fadeIn(200);
    }


    if ($('#site_statistics').size() != 0) {

        $('#site_statistics_loading').hide();
        $('#site_statistics_content').show();

        var plot_statistics = $.plot($("#site_statistics"), [{
            data: republicans,
            label: "Republican Tweets"
        }, {
            data: democrats,
            label: "Democrat Tweets"
        }
        ], {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.05
                        }, {
                            opacity: 0.01
                        }
                        ]
                    }
                },
                points: {
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#eee",
                borderWidth: 0
            },
            colors: ["#d12610", "#37b7f3", "#52e136"],
            xaxis: { ticks: xaxisdata },
            yaxis: {
                ticks: 11,
                tickDecimals: 0
            }
        });

        var previousPoint = null;
        $("#site_statistics").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showTooltip(item.pageX, item.pageY, item);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });

        $("#site_statistics").bind("plotclick", function (event, pos, item) {

            var dataItem;
            if (item) {
                if (item.seriesIndex == 0)
                    dataItem = Enumerable.From(GraphData).Where("x => x.Party == 'Republican'").ToArray()[item.dataIndex];

                if (item.seriesIndex == 1)
                    dataItem = Enumerable.From(GraphData).Where("x => x.Party == 'Democratic'").ToArray()[item.dataIndex];

                if (dataItem.Link)
                    window.open(dataItem.Link);
            }
        });
    }



}

function BindInfluencerTable(InfluencerData) {

    // Bind json data to Data Table

    var influencersData = Enumerable.From(InfluencerData).Select("x => [x['UserName'],x['Tweets'],x['Followers'],x['InfluencePercentile']]").Distinct().ToArray();

    var newRow;

    // Loop through each record and append row to the table
    for (var i in InfluencerData) {
        newRow = '<tr class="even gradeX"><td>' + InfluencerData[i].InfluencePercentile + '</td><td class=" "><a href="https://twitter.com/' + InfluencerData[i].UserName.replace(" ","") + '" target="_new">' + InfluencerData[i].UserName + '</a></td><td class=" "><a href="/Search/User/' + InfluencerData[i].UserID + '">' + InfluencerData[i].Tweets + '</td><td class=" ">' + addCommas(InfluencerData[i].Followers) + '</td><td><div class="progress" style="margin-bottom: 1px;width: 100%"><span class="progress-bar progress-bar-info" aria-valuemax="100" aria-valuemin="0" aria-valuenow="' + InfluencerData[i].InfluencePercentile + '" style="width: ' + InfluencerData[i].InfluencePercentile + '%;"></span></div></td></tr>';
        $('#influencersTable > tbody:last').append(newRow);
    }


    $('#influencersTable').dataTable({
        // set the initial value
        "iDisplayLength": 30,
        "data": influencersData,
        //  "order": [[2, "desc"]],
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aaSorting": [[0, "desc"]],
        "aoColumnDefs": [{ 'bSortable': true, 'aTargets': [0], "sType": "numeric" }]
    });




    jQuery('#influencersTable_wrapper .dataTables_filter input').addClass("form-control input-small");


}

function BindTweetsTable(TweetsData) {

    // Used for defining sorts
    var tweetsData = Enumerable.From(TweetsData).Select("x => [x['TweetScore'],x['UserName'],x['SenatorName'],x['TwitterText'],x['Party'],x['State'],x['StateName']]").ToArray();

    var newRow;
    var badge;
    var sen;


    for (var i in TweetsData) {

        sen = TweetsData[i];

        if (TweetsData[i].Party == "Democratic")
            badge = "dem";
        else
            badge = "rep";

        


        newRow = '                           <tr class="tweets-row">' +
                                      ' <td style="display: none;">"0"</td>' +
                                      ' <td class=""><a href="/SenatorDashboard/' + sen.SenatorKey + '">' +
                                      '     <img title="Sen. ' + sen.SenatorName + ' Source:Wikipedia.org" class="senate-pic" src="/senatepics/Senate_' + sen.SenatorKey + '.png"></a></td>' +
                                      ' <td>' +
                                      '     <ul class="tweetsbox">' +
                                      '         <li><a href="/SenatorDashboard/' + sen.SenatorKey + '"><span>' + sen.SenatorName + '</span><span class="badge ' + badge + '"> ' + sen.Party.substring(0, 1) + '-' + sen.State + '</span></a></li>' +
                                      '         <li><a href="#">' + sen.UserName + '</a><span> on ' + sen.DateCreatedString + '</span><span class="score">Score : ' + sen.TweetScore + '</span></li>' +
                                      '         <li><span class="tweettext">' + sen.TwitterText + '</span></li>';


                                            if (TweetsData[i].Hyperlink != "")
                                            {
                                               newRow = newRow + '<li><a target="new" class="pull-right" href="' + sen.Hyperlink + '">link</a></li>';
                                            }



                                           newRow = newRow + '</ul></td></tr>'





        $('#tweetsTable > tbody').append(newRow);
    }



    $('#tweetsTable').dataTable({
        // set the initial value
        "iDisplayLength": 15,
        "data": tweetsData,
        //   "order": [[4, "desc"]],
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aaSorting": [[0, "asc"]],
        "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0], "sType": "numeric" }]
    });



    jQuery('#tweetsTable_wrapper .dataTables_filter input').addClass("form-control input-small");


}

function BindSenatorTweetsTable(TweetsData) {

    var tweetsData = Enumerable.From(TweetsData).Select("x => [x['TweetScore'],x['UserName'],x['SenatorName'],x['TwitterText'],x['Party'],x['State'],x['StateName']]").ToArray();

    var newRow;
    var sen;


    for (var i in TweetsData) {

        sen = TweetsData[i];


        newRow = '                           <tr class="tweets-row">' +
                                      ' <td style="display: none;">"0"</td>' +
                                      ' <td>' +
                                      '     <ul class="tweetsbox">' +
                                      '         <li><a target="_new" href="https://twitter.com/' + sen.UserID + '">' + sen.UserName + '</a><span> on ' + sen.DateCreatedString + '</span><span class="score">Score : ' + sen.TweetScore + '</span></li>' +
                                      '         <li><span class="tweettext">' + sen.TwitterText + '</span></li>';


        if (TweetsData[i].Hyperlink != "") {
            newRow = newRow + '<li><a target="new" class="pull-right" href="' + sen.Hyperlink + '">link</a></li>';
        }



        newRow = newRow + '</ul></td></tr>'





        $('#tweetsTable > tbody').append(newRow);
    }



    $('#tweetsTable').dataTable({
        // set the initial value
        "iDisplayLength": 15,
        "data": tweetsData,
        //   "order": [[4, "desc"]],
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aaSorting": [[0, "asc"]],
        "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0], "sType": "numeric" }]
    });



    jQuery('#tweetsTable_wrapper .dataTables_filter input').addClass("form-control input-small");


}

function BindMostPopular(MostPopularData) {

    // Columns
    // SenatorKey	PicURL	SenatorName	Party	State	Tweets	TweetsPercentile	Impressions	ImpressionsPercentile	Score	SenatorRank	RankChange

    var newRow;
    var partyClass;

    for (var i in MostPopularData) {

        if (MostPopularData[i].Party == "Democratic")
            partyClass = "dem-bkg";
        else
            partyClass = "rep-bkg";


        if (MostPopularData[i].RankChange > 0)
            rankChange = '<span style="color:green;">&nbsp;(+' + MostPopularData[i].RankChange + ")</span>"
        else
            rankChange = '<span style="color:red;">&nbsp;(-' + MostPopularData[i].RankChange + ")</span>"







        newRow = '<tr class="' + partyClass + '"><td><a href="/SenatorDashboard/' + MostPopularData[i].SenatorKey + '">' + MostPopularData[i].SenatorName + '</a></td>' +
                                    '<td>' + MostPopularData[i].Party + '</td>' +
                                     '<td>' + MostPopularData[i].State + '</td>' +
                                    '<td>' + formatNumber(MostPopularData[i].Tweets, { decimals: 0 }) + '</td>' +
                                    '<td>' + formatNumber(MostPopularData[i].Impressions, { decimals: 0 }) + '</td>' +
                                    '<td>' + MostPopularData[i].Rank + rankChange +' </td></tr>';
        $('#MostPopularTable > tbody:last').append(newRow);
    }


    $('#MostPopularTable').dataTable({
        // set the initial value
        "iDisplayLength": 50,
        "data": MostPopularData,
        //  "order": [[2, "desc"]],
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aaSorting": [[0, "desc"]],
        "aoColumnDefs": [{ 'bSortable': true, 'aTargets': [0], "sType": "numeric" }]
    });




    jQuery('#influencersTable_wrapper .dataTables_filter input').addClass("form-control input-small");


}


function BindTrending(TrendingData) {

    // Columns
    // Words  Count  Change


    for (var i in TrendingData) {

        newRow = '<tr><td><a href="/Search/' + TrendingData[i].Word + '">' + TrendingData[i].Word  + '</a></td>' +
                                    '<td>' + TrendingData[i].Cnt + '</td><td>' + TrendingData[i].PctChange + '</td></tr>';
        $('#TrendingWordsTable > tbody:last').append(newRow);
    }


    $('#TrendingWordsTable').dataTable({
        // set the initial value
        "iDisplayLength": 50,
        "data": TrendingData,
        //  "order": [[2, "desc"]],
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aaSorting": [[0, "desc"]],
        "aoColumnDefs": [{ 'bSortable': true, 'aTargets': [0], "sType": "numeric" }]
    });




    jQuery('#influencersTable_wrapper .dataTables_filter input').addClass("form-control input-small");


}


function BindWordsTable(wordsData) {


    // Bind Data
    var word_array = [];
    var w;
    for (var i in wordsData) {

        w = new Object();
        w.text = wordsData[i].Word;
        w.weight = wordsData[i].Relevance;
        w.link = '/Search/' + wordsData[i].Word;

        word_array.push(w);
    }

    var settings = {
        width: 600,
        height: 500,
        shape: 'rectangular',
        delayedMode : true
    };

        $("#wordcloud").jQCloud(word_array,settings);



}

function BindSenatorsNavBar(SenatorData)
{

    var listItem;
    var badge;

    // Re-sort by State
    SenatorData.sort(compare);

// Loop through each senator and bind each record to a list item
    for (var i in SenatorData)
    {
        if (SenatorData[i].Party == "Democratic")
            badge = "dem";
        else
            badge = "rep";


            listItem = '<li id="senator_' + SenatorData[i].SenatorKey + '"><a href="/SenatorDashboard/' + SenatorData[i].SenatorKey + '" class="senator-menuitem">' + SenatorData[i].SenatorName + '<span class="badge ' + badge + '"> ' + SenatorData[i].Party.substring(0, 1) + '-' + SenatorData[i].StateAbbr + '</span></a></li>';
        $('#SenatorsSubMenu').append(listItem);
    }


}

 function compare(a,b) {
  if (a.State < b.State)
    return -1;
  if (a.State > b.State)
    return 1;
  return 0;
}


