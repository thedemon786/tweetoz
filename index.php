<?php

require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => getenv('token'),
'oauth_access_token_secret' => getenv('token_secret'),
'consumer_key' => getenv('key'),
'consumer_secret' => getenv('key_secret')
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
if (isset($_GET['user']))  {$user = preg_replace("/[^A-Za-z0-9_]/", '', $_GET['user']);}  else {$user  = "BarackObama";}
$getfield = "?screen_name=$user&count=10";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>TweetOz</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://bootswatch.com/4/spacelab/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="https://tweetoz.herokuapp.com/">TweetOz</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="https://tweetoz.herokuapp.com/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li> -->
            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="<?php echo htmlspecialchars($_SERVER["
                PHP_SELF"]);?>">
                <input name="user" class="form-control mr-sm-2" type="text" placeholder="Twitter Handle">
                <button class="btn btn-danger my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="jumbotron">
        <h1 class="display-3">Hello, world!</h1>
        <p class="lead">Here are the latest 10 tweets from
            <?php echo $user;?>
        </p>
        <hr class="my-4">
    </div>
    <div class="container">
        <div class="well">
            <div class="row">
                    <div class="card-deck">
                <?php
foreach($string as $items)
    { ?>
                <!-- <div class="col-sm-6 col-md-3">
                            <div class="card text-white bg-primary mb-3" style="width: 250px; height: 400px;">
                                <div class="card-header">Tweet</div>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <?php echo $items['user']['name'];?>
                                    </h4>
                                    <img class="card-img-top rounded-circle float-left" style="width: 50px; height: 70px; margin-right: 10px;" src="<?php echo $items['user']['profile_image_url'];?>" alt="Card image">
                                    <p class="card-text">
                                        <?php echo $items['text'];?>
                                    </p>
                                    <div class="card-footer text-muted">
                                    <small><?php echo "Time and Date: ".$items['created_at'];?></small>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    <div class="card text-white bg-primary mb-2" style="width: 250px; height: 400px;">
                            <div class="card-header">Tweet</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $items['user']['name'];?></h5>
                            <img class="card-img-top rounded-circle float-left" style="width: 50px; height: 70px; margin-right: 10px;" src="<?php echo $items['user']['profile_image_url'];?>" alt="Card image">
                            <p class="card-text"> <?php echo $items['text'];?></p>
                        </div>
                        <div class="card-footer">
                            <small><?php echo "Time and Date: ".$items['created_at'];?></small>
                        </div>
                    </div>

                    <!-- echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo "Tweet: ". $items['text']."<br />";
        echo "Image URL: ". $items['user']['profile_image_url']."<br />";
        echo "Tweeted by: ". $items['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br />"; -->
                    <?php 
                       
                      }?>
                </div>
                <p class="lead">
                    <a class="btn btn-danger" href="https://tweetoz.herokuapp.com/" role="button">Refresh</a>
                </p>
            </div>
        </div>
</body>

</html>