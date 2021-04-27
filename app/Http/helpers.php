<?php

function user()
{
    return auth()->user();
}

function isActiveRoute(string $route, string $output = "active")
{
    if (str_is($route, Route::currentRouteName())) return $output;
}

function isActiveMatch(string $string, string $output = "active")
{
    if (strpos(url()->current(), $string)) return $output;
}

function isActiveUrl(string $string, string $output = "active")
{
    if (str_is(url()->current(), $string)) return $output;
}

function customPaginate($entries, $perPage = 10)
{
    $page = Request::input('page', 1); // Get the ?page=1 from the url
    //$perPage = 2; // Number of items per page
    $offset = ($page * $perPage) - $perPage;

    $entries = new Illuminate\Pagination\LengthAwarePaginator(
        array_slice($entries, $offset, $perPage, true), // Items we need
        count($entries), // Total items
        $perPage, // Items per page
        $page, // Current page
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return $entries;
}

function implode_nm($array_expression, $col_name)
{
    $newArr = [];
    foreach ($array_expression as $value):
        $newArr[] = $value->$col_name;
    endforeach;
    return implode(', ', $newArr);
}

function newMsgsCount()
{
    $count = Auth::user()->newThreadsCount();
    if($count > 0) {
        return $count;
    }
}

function highlightString($str, $search_term = null) {
    if (is_null($search_term))
        return $str;

    $pos = strpos(strtolower($str), strtolower($search_term));

    if ($pos !== false) {
        $replaced = substr($str, 0, $pos);
        $replaced .= '<mark class="text-danger">' . substr($str, $pos, strlen($search_term)) . '</mark>';
        $replaced .= substr($str, $pos + strlen($search_term));
    } else {
        $replaced = $str;
    }

    return $replaced;
}

function isRated($model)
{
    return $model->ratings()->where('user_id', \Auth::id())->count() > 0;
}

// usage: {{ makeURL(route('dashboard.exercises.show', $exercise)) }}
function makeURL($url)
{
    if ( !strpos(url()->current(), 'dashboard') ) {
        $url = explode('/', $url);
        unset($url[3]);
        $url = implode('/', $url);
    }

    return $url;
}

// for logs.show & logs.edit - sort sets
function sortArrayByKeyAsc($_params)
{
    if(is_array($_params)){
        uksort($_params, 'strnatcmp');
        foreach ($_params as $key => $value){
            if(is_array($value)){
                $_params[$key] = sortArrayByKeyAsc($value);
            }
        }
    }
    return $_params;
}
