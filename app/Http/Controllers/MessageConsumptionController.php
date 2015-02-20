<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Commands\ProcessMessage;

class MessageConsumptionController extends Controller {
    
    /**
     * Receives a message through POST
     *
     * @param Request request
     * 
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $request->json();

        $v = \Validator::make($data->all(), [
            'currencyFrom' => 'required|size:3|different:currencyTo',
            'currencyTo' => 'required|size:3|different:currencyFrom',
            'originatingCountry' => 'required|size:2'
        ]);

        if ($v->fails()) {
            return new Response(
                'Sorry, bad data has been provided',
                Response::HTTP_BAD_REQUEST
            );
        }

        \Queue::push(new ProcessMessage(
            $data->get('currencyFrom'),
            $data->get('currencyTo'),
            $data->get('originatingCountry')
        ));

        return 'A message is successfully queued to be processed';
    }

}
