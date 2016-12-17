/*
        public void ProcessAgents(object source, System.Timers.ElapsedEventArgs e)
        {
            NextRefreshDate = DateTime.Now.AddMilliseconds(InternalTimer.Interval);
            string JSON = "";

            RefreshAgentjobs();

            int timeFrame = 0;
            int senatorKey = 0;

            // Loop through each notification
            foreach (DataAgentData a in DataAgentJobs.Where(a => a.NextRun < DateTime.Now))
            {
                try
                {
                    Dictionary<string, string> paramValues = Newtonsoft.Json.JsonConvert.DeserializeObject<Dictionary<string, string>>(a.ConfigData);

                    if (a.AgentType == "CongressDashboard") //Congress Dashboard
                    {
                        timeFrame = Convert.ToInt32(paramValues["TimeInterval"].ToString());
                        CongressDashboard dbCongress = new CongressDashboard(ConnectionString);
                        JSON = dbCongress.Render(timeFrame);
                    }

                    if (a.AgentType == "SenateDashboard") //Senate Dashboard
                    {
                        timeFrame = Convert.ToInt32(paramValues["TimeInterval"].ToString());
                        senatorKey = Convert.ToInt32(paramValues["SenatorKey"].ToString());
                        SenateDashboard dbSenate = new SenateDashboard(ConnectionString);
                        JSON = dbSenate.Render(timeFrame, senatorKey);
                    }


                    System.IO.File.WriteAllText(a.DestinationPath, JSON);

                    string SQL = "UPDATE TwitterFeed_Master.dbo.DataAgent SET LastRun = GETDATE(), NextRun = DATEADD(mi,IntervalMinutes,GETDATE()),ErrorMessage = '' WHERE DataAgentKey=" + a.DataAgentKey.ToString();
                    DataAccess.RunNonQuery(SQL, ConnectionString);
                }
                catch (Exception ex)
                {
                    string SQL = "UPDATE TwitterFeed_Master.dbo.DataAgent SET LastRun = GETDATE(), NextRun = DATEADD(mi,IntervalMinutes,GETDATE()),ErrorMessage = '" + ex.Message + "' WHERE DataAgentKey=" + a.DataAgentKey.ToString();
                    DataAccess.RunNonQuery(SQL, ConnectionString);
                }
            }


        }

        */



        /*


        using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

using Tweetinvi;
using TweetinCore.Interfaces.TwitterToken;
using System.Collections;
using System.Data;
using System.Text.RegularExpressions;


namespace TwitterAgent
{
    class TwitterAgent
    {


        public delegate void BatchProcessedEventHandler(int BatchKey);
        public delegate void BatchErrorEventHandler(int BatchKey,string ErrorMessage);
        public delegate void StatusChangedEventHandler(string OldStatus,string NewStatus);

        public event BatchProcessedEventHandler BatchProcessed;
        public event BatchErrorEventHandler BatchError;
        public event StatusChangedEventHandler StatusChanged;


        protected string ConsumerKey;
        protected string ConsumerSecret;
        protected string UserKey;
        protected string UserSecret;
        protected string ConnectionString;

        private string status;


        private List<TwitterFeed> ActiveFeeds = new List<TwitterFeed>();

        public string Status
        {
            get { return status; }
            set { 

                string oldStatus = status;
                
                status = value;

                if (StatusChanged != null)
                    StatusChanged(oldStatus, status);
  
            
                }
        }

        protected int RefreshIntervalMinutes=15;
        public DateTime NextRefreshDate;

        private System.Timers.Timer internalTimer;
        private string OperationalDBName;


        public TwitterAgent(string ConsumerKey, string ConsumerSecret, string UserKey, string UserSecret, string ConnectionString)
        {

            this.ConsumerKey = ConsumerKey;
            this.ConsumerSecret = ConsumerSecret;
            this.UserKey = UserKey;
            this.UserSecret = UserSecret;
            this.ConnectionString = ConnectionString;

            internalTimer = new System.Timers.Timer();
            internalTimer.Elapsed += new System.Timers.ElapsedEventHandler(CheckForFeeds);
        }

        public void Start()
        {
            CheckForFeeds(null, null);
            internalTimer.Interval = RefreshIntervalMinutes * 60000;
            internalTimer.Enabled = true;           
        }

        public void Stop()
        {
            if (this.internalTimer != null)
            this.internalTimer.Enabled = false;

            status = "Stopped";
        }


        public void GetTwitterDataTEST(object source, System.Timers.ElapsedEventArgs e)
        {
            Status = "Testing!";
        }


        public void CheckForFeeds(object source, System.Timers.ElapsedEventArgs e)
        {
            // Check the next feed date and time from the database
            DataSet dsActiveFeeds = DataAccess.RunQuery("SELECT FeedKey, FeedName, OperationalDatabaseName, Status, FrequencyMinutes, LastBatchDate, NextBatchDate, MostRecentBatchKey, DateCreated FROM Feed WHERE Status='A'", ConnectionString);

            string updateSQL;

            TwitterFeed currentFeed;

            ActiveFeeds = new List<TwitterFeed>();

            //Refresh the Feeds List
            foreach (DataRow r in dsActiveFeeds.Tables[0].Rows)
            {
                currentFeed = new TwitterFeed();

                currentFeed.FeedKey = Convert.ToInt32(r["FeedKey"].ToString());
                currentFeed.FeedName = r["FeedName"].ToString();
                currentFeed.FrequencyMinutes = Convert.ToInt32(r["FrequencyMinutes"].ToString());
                currentFeed.LastBatchDate = Convert.ToDateTime(r["LastBatchDate"]);
                currentFeed.MostRecentBatchKey = Convert.ToInt32(r["MostRecentBatchKey"].ToString());
                currentFeed.NextBatchDate = Convert.ToDateTime(r["NextBatchDate"]);
                currentFeed.OperationalDatabaseName = r["OperationalDatabaseName"].ToString();
                ActiveFeeds.Add(currentFeed);

            }


            //Loop through each Feed and Launch the ones which are overdue
            foreach(TwitterFeed f in ActiveFeeds.Where(a => a.NextBatchDate < DateTime.Now))
            {
              GetTwitterData(f);

                // Update the Twitter Feed
                updateSQL = "UPDATE Feed SET LastBatchDate = GETDATE(),NextBatchDate = DATEADD(mi,FrequencyMinutes,GETDATE()) WHERE FeedKey = " + f.FeedKey.ToString();
                DataAccess.RunNonQuery(updateSQL, ConnectionString);


            }


        }

        public void GetTwitterData(TwitterFeed CurrentFeed)
        {
            status = "Processing";

     
            int CurrentBatchKey=0;
            string url;
            IToken token = new TwitterToken.Token(UserKey, UserSecret, ConsumerKey, ConsumerSecret);


            List<System.Data.SqlClient.SqlParameter> p;

            DataSet dsSince = DataAccess.RunQuery("SELECT MAX(MaxTweetID) LastTweet FROM Batch WHERE STATUS = 'COMPLETE' AND FeedKey=" + CurrentFeed.FeedKey.ToString(), ConnectionString);


                string sinceID = dsSince.Tables[0].Rows[0][0].ToString();

                if (sinceID == "")
                    sinceID = "1";

                DataSet dsKeywords = DataAccess.RunQuery("SELECT SearchTerm FROM SearchTerm WHERE Status='A' AND FeedKey=" + CurrentFeed.FeedKey.ToString(), ConnectionString);
                string searchTerm = "";

                foreach (DataRow r in dsKeywords.Tables[0].Rows)
                {
                    //Loop through each keyword

                    searchTerm = r["SearchTerm"].ToString();

                    url = @"https://api.twitter.com/1.1/search/tweets.json?q=%22" + searchTerm + "%22&result_type=mixed&since_id=" + sinceID + "&lang=en&count=4000";

                    p = new List<System.Data.SqlClient.SqlParameter>();
                    p.Add(new System.Data.SqlClient.SqlParameter("@SearchTerm", searchTerm));
                    p.Add(new System.Data.SqlClient.SqlParameter("@FeedKey", CurrentFeed.FeedKey));
                    System.Data.DataSet dsBatchKey = DataAccess.GetStoredProcResults("usp_CreateNewBatch", p, ConnectionString);

                    CurrentBatchKey = Convert.ToInt32(dsBatchKey.Tables[0].Rows[0][0].ToString());
                    OperationalDBName = CurrentFeed.OperationalDatabaseName;
                    var result = token.ExecuteGETQueryReturningCollectionOfObjects(url, a => ProcessReturnResult(a,CurrentBatchKey), b => ExceptionHandler(b,CurrentBatchKey));


                }


            status = "Waiting";

            //NextRefreshDate = DateTime.Now.AddMinutes(RefreshIntervalMinutes);

            

            if (BatchProcessed != null)
                BatchProcessed(CurrentBatchKey);


        }

        private void ProcessReturnResult(Dictionary<string, object> t,int BatchKey)
        {


            Dictionary<string, object> currentUser;
            Dictionary<string, object> entities;
            string url;
            string OperationalConnectionString;
            string formattedTweet;


            List<System.Data.SqlClient.SqlParameter> p;

            
            var statuses = t["statuses"];


            foreach (Dictionary<string, object> tw in (IEnumerable<object>)statuses)
            {
                //Console.WriteLine("{0}, {1}",pair.Key,pair.Value);

                //@DateCreated datetime,
                //@TwitterID varchar(25),
                //@TweetText varchar(140),
                //@UserID int,
                //@RetweetCount int,
                //@FavoriteCount int,

                //@UserName varchar(50),
                //@ScreenName varchar(50),
                //@Location varchar(255),
                //@Description varchar(512),
                //@FollowersCount int,
                //@FriendsCount int,
                //@ListedCount int,
                //@UserDateCreated datetime

                currentUser = (Dictionary<string, object>)tw["user"];

                formattedTweet = ParseTweet(tw["text"].ToString());
                url = GetHyperlink(tw["text"].ToString());

              //  url = (new System.Collections.Generic.Dictionary<string, object>(((System.Collections.Generic.Dictionary<string, object>)(((object[])((new System.Collections.Generic.Dictionary<string, object>(((System.Collections.Generic.Dictionary<string, object>)((new System.Collections.Generic.Dictionary<string, object>(tw))["entities"]))))["urls"]))[0]))))["value"].ToString();

                //p[0].Value = tw["created_at"].ToString(); 
                //p[1].Value = tw["id"].ToString(); 
                //p[2].Value = tw["text"].ToString();
                //p[3].Value = currentUser["id"].ToString();
                //p[4].Value = tw["retweet_count"].ToString();
                //p[5].Value = tw["favorite_count"].ToString();

                //p[6].Value = currentUser["name"].ToString();
                //p[7].Value = currentUser["screen_name"].ToString();
                //p[8].Value = currentUser["location"].ToString();
                //p[9].Value = currentUser["description"].ToString();
                //p[10].Value = currentUser["followers_count"].ToString();
                //p[11].Value = currentUser["friends_count"].ToString();
                //p[12].Value = currentUser["listed_count"].ToString();
                //p[13].Value = currentUser["created_at"].ToString();

                p = new List<System.Data.SqlClient.SqlParameter>();

                p.Add(new System.Data.SqlClient.SqlParameter("@BatchKey", BatchKey));
                p.Add(new System.Data.SqlClient.SqlParameter("@DateCreated", tw["created_at"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@TwitterID", tw["id"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@TweetText", formattedTweet));
                p.Add(new System.Data.SqlClient.SqlParameter("@UserID", currentUser["id"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@RetweetCount", tw["retweet_count"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@FavoriteCount", tw["favorite_count"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@UserName", currentUser["name"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@ScreenName", currentUser["screen_name"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@Location", currentUser["location"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@Hyperlink", url));
                p.Add(new System.Data.SqlClient.SqlParameter("@Description", currentUser["description"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@FollowersCount", currentUser["followers_count"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@FriendsCount", currentUser["friends_count"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@ListedCount", currentUser["listed_count"].ToString()));
                p.Add(new System.Data.SqlClient.SqlParameter("@UserDateCreated", currentUser["created_at"].ToString()));

                //TODO - Find a more elegant solution here
                OperationalConnectionString = ConnectionString.Replace("TwitterFeed_Master", OperationalDBName);

                DataAccess.GetStoredProcResults("usp_NewTweet", p, OperationalConnectionString);



            }

            List<System.Data.SqlClient.SqlParameter> batchParams = new List<System.Data.SqlClient.SqlParameter>();

            batchParams.Add(new System.Data.SqlClient.SqlParameter("@BatchKey", BatchKey));
            batchParams.Add(new System.Data.SqlClient.SqlParameter("@Status", "COMPLETE"));


            DataAccess.GetStoredProcResults("usp_CloseBatch", batchParams, ConnectionString);


        }


        private string GetHyperlink(string rawTweet)
        {
            Regex link = new Regex(@"http(s)?://([\w+?\.\w+])+([a-zA-Z0-9\~\!\@\#\$\%\^\&amp;\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?");
            string url = link.Match(rawTweet).ToString();
            return url;
        }


        private string ParseTweet(string rawTweet)
        {
            Regex link = new Regex(@"http(s)?://([\w+?\.\w+])+([a-zA-Z0-9\~\!\@\#\$\%\^\&amp;\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?");
            Regex screenName = new Regex(@"@\w+");
            //Regex hashTag = new Regex(@"#\w+");

            string formattedTweet = link.Replace(rawTweet, "");
            formattedTweet = screenName.Replace(formattedTweet, "");


            //string formattedTweet = link.Replace(rawTweet, delegate(Match m)
            //{
            //    string val = m.Value;
            //    return "<a href='" + val + "'>" + val + "</a>";
            //});

            //formattedTweet = screenName.Replace(formattedTweet, delegate(Match m)
            //{
            //    string val = m.Value.Trim('@');
            //    return string.Format("@<a href='http://twitter.com/{0}'>{1}</a>", val, val);
            //});

            //formattedTweet = hashTag.Replace(formattedTweet, delegate(Match m)
            //{
            //    string val = m.Value;
            //    return string.Format("<a href='http://twitter.com/#search?q=%23{0}'>{1}</a>", val, val);
            //});

            return formattedTweet;
        }


        private void ExceptionHandler(System.Net.WebException e,int BatchKey)
        {
            // Mark Batch as Error
            List<System.Data.SqlClient.SqlParameter> batchParams = new List<System.Data.SqlClient.SqlParameter>();

            batchParams.Add(new System.Data.SqlClient.SqlParameter("@BatchKey", BatchKey));
            batchParams.Add(new System.Data.SqlClient.SqlParameter("@Status", "ERROR"));


            DataAccess.GetStoredProcResults("usp_CloseBatch", batchParams, ConnectionString);

            if (BatchError != null)
                BatchError(BatchKey, e.ToString());
        }

        private void StatusChangedHandler(string OldStatus, string NewStatus)
        {

        }


}

    class TwitterFeed
    {
        public int FeedKey { get; set; }
        public string FeedName { get; set; }
        public string OperationalDatabaseName { get; set; }
        public int FrequencyMinutes { get; set; }
        public DateTime LastBatchDate { get; set; }
        public DateTime NextBatchDate { get; set; }
        public int MostRecentBatchKey { get; set; }
    }
}


*/


