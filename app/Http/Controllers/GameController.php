<?php

namespace App\Http\Controllers;

use App\Exports\GameExport;
use App\Helpers\ResponseHelper;
use App\Http\Resources\StateResource;
use App\Imports\GameImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GameController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        return Excel::download(new GameExport, 'game.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return StateResource
     */
    public function store()
    {
        $data = $this->validate(request(), [
            'file' => 'required|file'
        ]);
        $result = Excel::import(new GameImport, request('file'));
        return $this->sendSuccess( 'Action Completed Successfully');
    }
}
