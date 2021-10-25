<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Url;

class UrlController extends Controller
{
    /**
     * Create and store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $hash = Str::random(7);
        $encurtedUrl = env('APP_URL') . "/api/shortner/" . $hash;
        $originalUrl = $request->url;

        $newUrl = Url::create([
            'originalUrl' => $originalUrl,
            'encurtedUrl' => $encurtedUrl,
            'hash' => $hash
        ]);

        return response($encurtedUrl, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $originalUrl = Url::where('hash', $url)->first();

        if (isset($originalUrl)) {
            return response($originalUrl['originalUrl'], 200);
        } else {
            return response("Url not found", 404);
        }
    }
}
