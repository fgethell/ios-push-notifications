<?php
    //fbgraph fetch request url here
    $graph_url = "https://graph.facebook.com/(Insert Page ID)/posts?limit=1&fields=id&access_token=(Insert API Key)"; 
    
    
    $new = json_decode(file_get_contents($graph_url), true); 
    $latestpostid = $new['data']['0']['id'];

    //this will save the last id in a text file "ids.txt"
    $testpostid = file_get_contents('ids.txt', NULL, NULL, 0, 32);

    if($latestpostid == $testpostid) {
    echo "NO NEW POSTS";
    }
    else {
    echo "NEW POSTS";
    exec("wget [link of your php file which sends notification (iosnotif.php in our case)]");
    unlink("ids.txt");
    file_put_contents('ids.txt', $latestpostid); 
    }
    
?>