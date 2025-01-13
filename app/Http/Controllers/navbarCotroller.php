<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class navbarCotroller extends Controller
{
    public function handleRequest(Request $request)
    {
        $data = $request->input('data');

        if (is_array($data) || is_object($data)) {
            foreach ($data as $item) {
                // Process each item
            }
        } else {
            // Handle the case where $data is not an array or object
        }
    }
}
