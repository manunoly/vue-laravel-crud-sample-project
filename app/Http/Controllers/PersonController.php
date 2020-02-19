<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use Exception;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Person::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exist = Person::where('email', $request->email)->first();
        if ($exist)
            return $this->returnError('Email already exists');

        $person = new Person;

        $person->name = $request->name;
        $person->lastName = $request->lastName;
        $person->email = $request->email;
        $person->ci = $request->ci;

        try {
            $person->save();
        } catch (Exception $e) {
            return $this->returnError();
        }

        return $person;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Person::where('id', $id)->first();
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
        $person = Person::find($id);
        // var_dump($request->email);
        if ($person) {

            $exist = Person::where('email', $request->email)->first();
            if ($exist && $exist->id != $id)
                return $this->returnError('Email already used by other person');

            $person->name =  $request->name;
            $person->lastName = $request->lastName;
            $person->email = $request->email;
            $person->ci = $request->ci;

            try {
                if ($person->save())
                    return 'success';
            } catch (Exception $e) {
                return $this->returnError();
            }
        } else {
            return $this->returnError('Person not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $person = Person::find($id);
            if ($person && $person->delete())
                return 'success';
            else
                return $this->returnError("User not found or can't deleted");
        } catch (Exception $e) {
            return $this->returnError();
        }
    }


    /**
     * Return Error
     * @param  String  message
     * @return \Illuminate\Http\Response
     */

    public function returnError($message = 'Uppss... something wrong')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 400);
    }
}
