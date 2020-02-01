<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\ManagementModel;

class ManagementController extends Controller
{
    public $successStatus = 200;
    
    public function allData(){
        $data = ManagementModel::
                select( 'management.id',
                        'management.user_id',
                        'users.name as nama_user',
                        'management.letter_id',
                        'm_letter.name as letter_name',
                        'm_letter.description as letter_description',
                        'm_letter.type as letter_type',
                        'management.jumlah',
                        'management.created_at',
                        'management.updated_at' )
                ->leftJoin('users' , 'management.user_id' , '=' , 'users.id')
                ->leftJoin('m_letter' , 'management.letter_id' , '=' , 'm_letter.id')
                ->get();
                
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
        $data = ManagementModel::
        select( 'management.id',
                'management.user_id',
                'users.name as nama_user',
                'management.letter_id',
                'm_letter.name as letter_name',
                'm_letter.description as letter_description',
                'm_letter.type as letter_type',
                'management.jumlah',
                'management.created_at',
                'management.updated_at' )
        ->leftJoin('users' , 'management.user_id' , '=' , 'users.id')
        ->leftJoin('m_letter' , 'management.letter_id' , '=' , 'm_letter.id')
        ->where('management.id',$id)
        ->get();
        
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
        $data = new ManagementModel();
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $format = $file->getClientOriginalExtension();
        $path = "/uploads"."/".$fileName;
        $source = "/uploads"."/".$fileName;

        if($format == 'jpeg' || $format == 'JPEG' || $format == 'JPG' || $format == 'jpg' || $format == 'png') {
            $data->user_id = $request->user_id;
            $data->letter_id = $request->letter_id;
            $data->jumlah = $request->jumlah;
            $data->file_path = $path;
            $data->save();
            
            $file->move('uploads', $file->getClientOriginalName());
            return response()->json([
                'success' => true,
                'message' => 'Insert Data Success'
            ]);
        } else {
            return response('Gagal Tersimpan');
        }
    }

    public function updateData(Request $request,$id){
        $data = ManagementModel::where('id',$id)->first();
        $cekfile = $request->file('file');

        if($cekfile == null){
            $path = $data->file_path;
            $format = "jpg";
        }else{
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $format = $file->getClientOriginalExtension();
            $path = "/uploads"."/".$fileName;
            $source = "/uploads"."/".$fileName;
            $file->move('uploads', $file->getClientOriginalName());
        }
    
        if($format == 'jpeg' || $format == 'JPEG' || $format == 'JPG' || $format == 'jpg' || $format == 'png') {
            $data->user_id = $request->user_id;
            $data->letter_id = $request->letter_id;
            $data->jumlah = $request->jumlah;
            $data->file_path = $path;
            $data->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Update Data Success'
            ]);
        } else {
            return response('Gagal Tersimpan');
        }

    }

    public function deleteData($id){
        $data = ManagementModel::where('id',$id)->first();
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Data Success'
        ]);
    }

    public function paginationAlldata($show_data,$page){

        $offset = ((int)$page-1)*(int)$show_data;
        $limit = (int)$show_data;

        $dataTotal = ManagementModel::all();
        $rowCont = count($dataTotal);

        $data = ManagementModel::
                select( 'management.id',
                        'management.user_id',
                        'users.name as nama_user',
                        'management.letter_id',
                        'm_letter.name as letter_name',
                        'm_letter.description as letter_description',
                        'm_letter.type as letter_type',
                        'management.jumlah',
                        'management.created_at',
                        'management.updated_at' )
                ->leftJoin('users' , 'management.user_id' , '=' , 'users.id')
                ->leftJoin('m_letter' , 'management.letter_id' , '=' , 'm_letter.id')
                ->offset($offset)
                ->limit($limit)
                ->get();
                
        $totalPage = ceil($rowCont/(int)$show_data);

    
        $rowPagination = count($data);
        $massage = '';
        if ($rowPagination == 0){
            $massage = "Data Not Found";
        }else{
            $massage = "Success";
        }

        return response()->json(['data' => $data, 'status' => $massage, 'current_page' => $page  , 'current_data' => $rowPagination , 'total_page' => $totalPage, 'total_data' => $rowCont], $this->successStatus);

    }

}