<?php

namespace Modules\SsoClient\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_host = $_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST']; //$request->session()->get('_previous')['url'];
        if(isset($current_host) && stripos(json_encode(['localhost', '127.0.0.1', '127.0.0.0']),$current_host) !== false) {
            // skip local redirect
            $split_url = explode('://',auth()->user()->roles->first()->redirect_url);
            if(count($split_url) > 1) {
                $split_url = explode('/',$split_url[1]);
                $split_url[0] = '';
                return redirect(implode('/', $split_url));
            } else {
                return redirect($split_url[0]);
            }
            return redirect($split_url[count($split_url) - 1]);
        } else if (auth()->user()->roles->count() == 1) {
            return redirect(auth()->user()->roles->first()->redirect_url);
        }

        return view('ssoclient::welcome', [
            'roles' => auth()->user()->roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
