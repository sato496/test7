<?php

if (!function_exists('sortLink')) {
    function sortLink($label, $column)
    {
        $direction = request()->get('direction') === 'asc' ? 'desc' : 'asc';
        $url = request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => $direction,
        ]);
        return '<a href="' . $url . '">' . $label . '</a>';
    }
}
