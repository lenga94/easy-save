<?php

namespace App\Http\Controllers;

use App\Client;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

class ClientsController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     * Return the list of all clients
     * @return Response|ResponseFactory
     */
    public function index()
    {
        $clients = Client::all();

        return $this->successResponse($clients);
    }

    /**
     * Create one new client
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'nullable|numeric|min:1',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'other_names' => 'nullable|max:255',
            'title' => 'nullable|max:255',
            'dob' => 'nullable|date_format:Y-m-d|before_or_equal:today',
            'gender' => 'nullable|max:255|in:MALE,FEMALE',
            'marital_status' => 'nullable|max:255',
            'nationality' => 'nullable|max:255',
            'tribe' => 'nullable|max:255',
            'nrc' => 'required|max:255',
            'birth_place' => 'nullable|max:255',
            'passport_number' => 'nullable|max:255',
            'phone_number' => 'required|max:255',
            'residential_address' => 'nullable|max:255',
            'postal_address' => 'nullable|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2500',
        ];


        $this->validate($request, $rules);

        //check if client exists
        $client = Client::where('nrc', $request->nrc)
            ->orWhere('phone_number', $request->phone_number)->first();

        //if client exists send error message
        if($client) {
            $nrc = $client->nrc;
            $phoneNumber = $client->phone_number;
            $message = "";

            if($nrc == $request->nrc && $phoneNumber == $request->phone_number) {
                $message = "Client exists with phone number and nrc provided";
            } else if($nrc == $request->nrc && $phoneNumber != $request->phone_number) {
                $message = "Client exists with nrc provided";
            } else if($nrc != $request->nrc && $phoneNumber == $request->phone_number) {
                $message = "Client exists with phone number provided";
            }

            return $this->errorResponse($message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //if client doesnt exist create new client
        if($request->hasFile('profile_photo')) {

            //Get just extension
            $extension = $request->file('profile_photo')->getClientOriginalExtension();

            //filename to store
            $filename = rand(111, 99999) .'.'. $extension;

            //Upload Document
            $path = $request->file('profile_photo')->storeAs('public/clients/profile_images/', $filename);

            $client = Client::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'other_names' => $request->other_names,
                'title' => $request->title,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'nationality' => $request->nationality,
                'tribe' => $request->tribe,
                'nrc' => $request->nrc,
                'birth_place' => $request->birth_place,
                'passport_number' => $request->passport_number,
                'phone_number' => $request->phone_number,
                'residential_address' => $request->residential_address,
                'postal_address' => $request->postal_address,
                'profile_photo' => $path,
            ]);

        } else {
            $client = Client::create($request->all());
        }

        if($client == null) {
            return $this->errorResponse('Unable to create client', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->successResponse($client, Response::HTTP_CREATED);
    }

    /**
     * Obtains and shows one client
     * @param $client
     * @return Response|ResponseFactory
     */
    public function show($client)
    {
        $client = Client::findOrFail($client);

        return $this->successResponse($client);
    }

    /**
     * Update an existing client
     * @param Request $request
     * @param $client
     * @return Response|ResponseFactory
     * @throws ValidationException
     */
    public function update(Request $request, $client)
    {
        $rules = [
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'other_names' => 'max:255',
            'title' => 'max:255',
            'dob' => 'date_format:Y-m-d|before_or_equal:today',
            'gender' => 'max:255|in:MALE,FEMALE',
            'marital_status' => 'max:255',
            'nationality' => 'max:255',
            'tribe' => 'max:255',
            'nrc' => 'max:255',
            'birth_place' => 'max:255',
            'passport_number' => 'max:255',
            'dial_code' => 'max:255',
            'phone_number' => 'max:255',
            'residential_address' => 'max:255',
            'postal_address' => 'max:255',
            'profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2500',
        ];


        $this->validate($request, $rules);

        $client = Client::findOrFail($client);

        if($request->hasFile('profile_photo')) {

            //Get just extension
            $extension = $request->file('profile_photo')->getClientOriginalExtension();

            //filename to store
            $filename = rand(111, 99999) .'.'. $extension;

            //Upload Document
            $path = $request->file('profile_photo')->storeAs('public/clients/profile_images/', $filename);

            $client->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'other_names' => $request->other_names,
                'title' => $request->title,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'nationality' => $request->nationality,
                'tribe' => $request->tribe,
                'nrc' => $request->nrc,
                'birth_place' => $request->birth_place,
                'passport_number' => $request->passport_number,
                'phone_number' => $request->phone_number,
                'residential_address' => $request->residential_address,
                'postal_address' => $request->postal_address,
                'profile_photo' => $path,
            ]);

        } else {
            $client->fill($request->all());
        }


        if($client->isClean()) {
            return $this->errorResponse('At least one value must change to update client',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        //check if client exists with provided phone number or nrc
        $client = Client::where('nrc', $request->nrc)
            ->orWhere('phone_number', $request->phone_number)->first();

        //if client exists send error message
        if($client) {
            $nrc = $client->nrc;
            $phoneNumber = $client->phone_number;
            $message = "";

            if($nrc == $request->nrc && $phoneNumber == $request->phone_number) {
                $message = "Client exists with phone number and nrc provided";
            } else if($nrc == $request->nrc && $phoneNumber != $request->phone_number) {
                $message = "Client exists with nrc provided";
            } else if($nrc != $request->nrc && $phoneNumber == $request->phone_number) {
                $message = "Client exists with phone number provided";
            }

            return $this->errorResponse($message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $client->save();

        return $this->successResponse($client);
    }

    /**
     * Remove an existing client
     * @param $client
     * @return Response|ResponseFactory
     */
    public function destroy($client)
    {
        $client = Client::findOrFail($client);

        $client->delete();

        return $this->successResponse($client);
    }
}
