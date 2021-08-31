<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProduct;
use App\Http\Requests\Api\UpdateProduct;
use App\Models\product;
use Illuminate\Http\Request;
use Swoole\Http\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ProductController extends Controller
{
    public function index($id = null)
    {
        $result  = $id ? product::find($id) : product::all();
        $message = [
            'status' => 200,
            'result' => $result
        ];
        return response($message);
    }

    public function store(StoreProduct $request)
    {
        if (!$request->validator->fails()) {
            product::create([
                'name' => $request->name,
                'description' => $request->description,
                'section_id' => $request->section_id,
                'created_by' => $request->created_by,
            ]);
            $message = [
                'status' => 200,
                'result' => 'Product Added Successfully'
            ];
        } else {
            $message = [
                'status' => 400,
                'Errors' => $request->validator->getMessageBag()
            ];
        }
        return response($message);
    }

    public function update(UpdateProduct $request, $id)
    {
        $product = product::find($id);
        if (!$request->validator->fails() && $product) {
            $product->update([
                'name' => $request->name  ? $request->name  : $product->name,
                'description' => $request->description ? $request->description  : $product->description,
                'section_id' => $request->section_id ? $request->section_id  : $product->section_id,
                'created_by' => $request->created_by ? $request->created_by  : $product->created_by,
            ]);
            $message = [
                'status' => 200,
                'result' => 'Product Updated Successfully'
            ];
        } else {
            $message = [
                'status' => 400,
                'result' => 'Product Failed To Updated',
                'Errors' => $request->validator->getMessageBag()
            ];
        }
        return Response($message);
    }

    public function delete($id)
    {
        $product = product::find($id);
        if ($product) {
            $product->delete();
            $message = [
                'status' => 200,
                'result' => 'Product Deleted Successfully'
            ];
        } else {
            $message = [
                'status' => 400,
                'result' => 'Unkown Product with This Id',
            ];
        }
        return Response($message);
    }

    public function sereach($any)
    {
        $product = product::where('name', 'like', "%{$any}%")->get();
        if ($product) {
            $message = [
                'status' => 200,
                'count Record' => count($product),
                'result' => $product
            ];
        } else {
            $message = [
                'status' => 400,
                'result' => 'No Record With This string',
            ];
        }
        return response($message);
    }
}
