<?php

namespace App\Http\Controllers\Api;

use App\Models\section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\StoreSection;
use App\Http\Requests\Api\UpdateSection;

class SectionController extends Controller
{
    public function index($id = null)
    {
        $result =   $id ? section::find($id) : $result = section::all();
        $success = [
            'status' => 200,
            'Result' => $result
        ];
        return response($success, 200);
    }

    public function store(StoreSection $request)
    {
        if (!$request->validator->fails()) {
            section::create([
                'name_section' => $request->name_section,
                'description' => $request->description,
                'created_by' => $request->created_by,
            ]);
            $messages = [
                'status' => 200,
                'result' => 'Section Added Successfully',
            ];
        } else {
            $messages = [
                'Status' => 400,
                'Result' => 'Section Failed Added',
                'Errors' => $request->validator->getMessageBag(),
            ];
        }
        return response($messages);
    }


    public function update(UpdateSection $request, $id)
    {
        $section = section::find($id);
        if (!$request->validator->fails() && $section) {
            $section->update([
                'name_section' => $request->name_section ? $request->name_section : $section->name_section,
                'description' => $request->description ?  $request->description : $section->description,
                'created_by' => $request->created_by ? $request->created_by : $section->created_by,
            ]);
            $messages = [
                'status' => 200,
                'result' => 'Section Updated Successfully',
            ];
        } else {
            $messages = [
                'Status' => 400,
                'Result' => 'Section Failed Added',
                'Errors' => $request->validator->getMessageBag(),
            ];
        }
        return response($messages);
    }

    public function delete($id)
    {
        $section = section::find($id);
        if ($section) {
            $section->delete();
            $message = [
                'status' => 200,
                'result' => 'Section Deleted Successfully'
            ];
        } else {
            $message = [
                'status' => 400,
                'result' => 'Unkown Section With This Id'
            ];
        }
        return response($message);
    }

    public function sereach($any)
    {
        $section = section::where('name_section', 'like', "%{$any}%")->get();
        if ($section) {
            $message = [
                'status' => 200,
                'Count Record' => count($section),
                'result' => $section
            ];
        } else {
            $message = [
                'status' => 400,
                'result' => 'Unkown name_section with this String'
            ];
        }
        return response($message);
    }
}
