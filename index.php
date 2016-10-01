<?php
/*******************************************************************************
 * VARIABLES
 ******************************************************************************/

$github_repo_url = 'https://api.github.com/users/freemagee/repos';
$repo_list = get_repo_list($github_repo_url);
$date_ordered_ids = create_sort_list($repo_list);
$reordered_repo_list = sort_repos_by_date($repo_list, $date_ordered_ids);

/*******************************************************************************
 * FUNCTIONS
 ******************************************************************************/

/**
 * [get_list my GitHub repos via API]
 * @return [array] [list of top story IDs]
 */
function get_repo_list($url) {
    $ch = curl_init();
    $headers = ['User-Agent: nm-portfolio'];

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $list = curl_exec($ch);
    $list_obj = json_decode($list);
    $list = object_to_array($list_obj);

    return $list;
}

/**
 * [object_to_array does what it says on the tin]
 * @param  [object] $d [input object]
 * @return [array]    [output array]
 */
function object_to_array($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}

/**
 * [sort_repos_by_date description]
 * @param  [type] $list [description]
 * @return [type]       [description]
 */
function create_sort_list($list) {
    $date_ordered_list = array();

    // Loop over list, add the id as a key and add a time value
    foreach ($list as $key => $value) {
        $id = $list[$key]['id'];
        $date_ordered_list[$id] = strtotime($list[$key]['pushed_at']);
    }

    // Now sort the list based on the time values
    arsort($date_ordered_list);

    return $date_ordered_list;
}

function sort_repos_by_date($list, $sort_by) {
    $sorted_list = array();

    $limit = count($list);

    for ($i = 0; $i < $limit; $i++) {
        $id = $list[$i]['id'];

        if (array_key_exists($id, $sort_by)) {
            $pos = array_search($id, array_keys($sort_by));
            $sorted_list[$pos] = $list[$i];
        }
    }

    return $sorted_list;
}

/**
 * [pre_r pretty print]
 * @param  [array or object] $val [source data to be printed]
 */
function pre_r($val) {
    echo '<pre>';
    print_r($val);
    echo  '</pre>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Neil Magee | Lead Front-end Developer | Leicester</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:700|Neuton:400,700">
    <link rel="stylesheet" href="/library/css/style.css">
</head>
<body class="home">
    <div class="intro">
        <div class="inner">
            <div class="logo"><img src="/library/img/logo.svg" alt="NM" /></div>
            <h1 class="title title__light">Neil Magee</h1>
            <h2 class="subtitle subtitle__light">Lead Front-end Developer</h2>
        </div>
    </div>
    <div class="about">
        <div class="inner">
            <h2 class="subtitle">About me</h2>
            <div class="text text__col">
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.</p>
                <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.</p>
            </div>
        </div>
    </div>
    <div class="projects">
        <div class="inner">
            <h2 class="subtitle subtitle__light">Projects</h2>
            <ul class="project project--github">
                <?php
                foreach ($reordered_repo_list as $key => $value) {
                    echo '<li class="project__item"><a href="' .  $reordered_repo_list[$key]['url'] . '" class="project__link">' .$reordered_repo_list[$key]['name'] . "</a></li>";
                }
                ?>
            </li>
        </div>
    </div>
</body>
</html>