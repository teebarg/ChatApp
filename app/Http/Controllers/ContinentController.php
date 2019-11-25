<?php

namespace App\Http\Controllers;

use App\Continent;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Helpers\ResponseHelper;
use App\Http\Resources\ContinentResource;
use Illuminate\Http\Request;

class ContinentController extends BaseController
{
    /**
     * Create a new ContinentController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['jwt.verify']);
        $this->middleware(['role:Admin|Super Admin']);
        $this->middleware(['role:Super Admin'], ['only' => ['update', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $limit = request('limit', 10);
        $continents = Continent::paginate($limit);
        return ContinentResource::collection($continents)
            ->additional(ResponseHelper::additionalInfo(ResponseMessages::ACTION_SUCCESSFUL, ResponseCodes::ACTION_SUCCESSFUL));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ContinentResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $data = $this->validate(request(), [
            'continent_name' => 'required|min:2|unique:continents',
            'continent_alias' => 'required|min:2|unique:continents',
        ]);
        $continent = Continent::create($data);
        return new ContinentResource($continent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Continent  $continent
     * @return ContinentResource
     */
    public function show(Continent $continent)
    {
        //
        return new ContinentResource($continent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Continent  $continent
     * @return ContinentResource
     */
    public function update(Request $request, Continent $continent)
    {
        $continent->update($request->all());
        return new ContinentResource($continent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Continent $continent
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Continent $continent)
    {
        $continent->delete();
        return $this->sendSuccess('Resource deleted Successfully');
    }
}
