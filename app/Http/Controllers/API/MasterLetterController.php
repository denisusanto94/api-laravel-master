<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\MasterLetterModel;

class MasterLetterController extends Controller
{
    public $successStatus = 200;

    public function allData(){
        $data = MasterLetterModel::all();
        $rowCont = count($data);
        $massage = '';
        if ($rowCont == 0){
            $massage = "Data Not Found";
        }else{
            $massage = "Success";
        }

        return response()->json(['data' => $data, 'status' => $massage, 'length' => $rowCont], $this->successStatus);
    }

    public function getData($id){
        $data = MasterLetterModel::where('id',$id)->get();
        $rowCont = count($data);
        $massage = '';
        if ($rowCont == 0){
            $massage = "Data Not Found";
        }else{
            $massage = "Success";
        }
        return response()->json(['data' => $data, 'status' => $massage, 'length' => $rowCont], $this->successStatus);
    }
    
    public function insertData(Request $request){
        $data = new MasterLetterModel();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->type = $request->type;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Insert Data Success'
        ]);
    }

    public function updateData(Request $request, $id){
        $data = MasterLetterModel::where('id',$id)->first();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->type = $request->type;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Update Data Success'
        ]);
    }

    public function deleteData($id){
        $data = MasterLetterModel::where('id',$id)->first();
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Data Success'
        ]);
    }

}