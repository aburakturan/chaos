<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use Exception;
use Illuminate\Http\Request;
use Validator;

class FileController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $entity = $request->input('entity');

        try {
            $row = $entity::findOrFail($id);

            // Validate
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'entity' => 'required',
            ]);

            if ($validator->fails()) {
                throw new Exception(array_values($validator->messages()->toArray())[0][0]);
            }

            // Remove via FileTrait
            $row->destroyFile($name);

            $response = [
                'title' => 'Başarılı!',
                'message' => 'Bu dosya başarıyla silindi.',
                'success' => true,
            ];
        } catch (Exception $e) {
            $response = [
                'title' => 'Bir hata meydana geldi!',
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return response()->json($response);
    }
}
