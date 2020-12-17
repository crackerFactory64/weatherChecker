<?php

   

    if($_POST){
        
        $city = rtrim($_POST["city"]); // trims any space from the end of the input and creates a variable to be used in the creation of the URL which will be used in the fetching of the weather data
        
        $city = ucwords($city); //ensures all words in the city name are capitalised, a requirement for the URL structure
    
        $urlCity = str_replace(" ", "-", $city); //replaces any spaces in the input with hyphens to create a variable which produces a valid URL    
                                
        $url = "https://www.weather-forecast.com/locations/".ucfirst($urlCity)."/forecasts/latest"; //creates the URL to use to fetch the forecast info 
                
        $page = file_get_contents($url); //gets the contents of the URL and stores them in a variable for use in the function on the next line

        preg_match("/<span class=\"phrase\".*span>/", $page, $matches); //creates an array ($matches) by searcing the fetched page for anything within a span with the class of "phrase"

        $error = "";

        $forecast = "";
        

        if ($_POST['city'] == ""){
            
            $error = '<div class="alert alert-warning" role="alert">Please enter a city</div>';
            
        } else if ($_POST['city'] != "" && get_headers($url)[0] != "HTTP/1.1 200 OK"){

            // checks if the URL and therefore the city is valid by checking the headers array of the url

            $error = '<div class="alert alert-warning" role="alert">Please enter a valid city</div>';

        } else if ($error == ""){
            
            //creates the forecast text to be displayed. snips the relevant text from the rest of the webpage by extracting everything before the name of the city
            
            $forecast = '<div class="alert alert-success" role ="alert">'.'<strong>Current '.ucfirst($_POST["city"])." Weather: </strong> <br><br>".strstr(($matches[0]), ucfirst($city), true).'</div>';  
            
        }
        

    }
?>

<style type="text/css">

    body{
        
        background-image: url("https://images.unsplash.com/photo-1571217668979-f46db8864f75?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80");
        
    }
    
    .container{
        margin-top: 150px;
    }

    .container h1{
        
        font-size: 72px;
        color: #29303B;
        
    }
    
    .container input{
        
        width: 93%;
        float: left;
        margin-top: 50px;
    }
    
    .container button{
        
        float: left;
        margin-top: 50px;
    }
    
    .clear{
        
        clear: both;
    }
    
    #results{
        
        margin-top: 100px;
        width: 80%;
        position: relative;
        left: 10%;
        
        
    }


</style>

<!doctype html>
<html lang="en">
  
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
        <title>Weather Checker</title>

    </head>
  
    <body>
        
        <div class="container">
            
           
            
            <h1>How's the Weather?</h1>
            
            <div class="clear"></div>

            <form method="post">
               
                <p><input type="text" class="form-control" id="city" placeholder="Enter a city" name="city"><button type="submit" class="btn btn-primary">Submit</button></p>
            
            </form>
            
            <div class="clear"></div>
             
            <div id="results"><? echo $error.$forecast ?></div>
            
            <div class="clear"></div>

        
        </div>
        
        
        
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
    
        <script type="text/javascript">
            
            
            $("form").submit(function(){
                
                if ($("#city").val() == ""){
                    
                    $("#results").html('<div class="alert alert-warning" role="alert">Please enter a city</div>');
                    return false;
                }
                
            })        
            
        </script>
    </body>
</html>