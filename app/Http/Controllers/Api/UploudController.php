<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploudController extends Controller
{
    public function UploudImage(Request $request)
    {
        $image = $request->image;
        $namafile = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('uploud/image');
        $image->move($path, $namafile);

        return response()->json([
            'image_path' => '/uploud/image' . $namafile,
            'base_url' => url('/'),
        ]);
    }
    public function UploudMultipleImage(Request $request)
    {
        if ($request->has('image')) {
            $images = $request->image;
            foreach ($images as $key => $image) {
                $namafile = time() . $key . '.' . $image->getClientOriginalExtension();
                $path = public_path('uploud/image');
                $image->move($path, $namafile);
            }
            return response()->json([
                'status' => 'sukses',
            ]);
        }



    }
}
