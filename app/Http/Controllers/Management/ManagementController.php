<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Mbagian;
use App\Models\Mkaryawan;
use App\Models\Mpekerjaan;
use App\Models\Mgroup;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\kasbon\MdataPinjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->karyawan =  new Mkaryawan();
        $this->pinjaman = new MdataPinjaman();
        $this->group    = new Mgroup();
        $this->pekerjaan =  new Mpekerjaan();
        $this->bagian =  new Mbagian();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showManagement()
    {
        return view('management.user');
    }

    public function showProfile()
    {
        return view('management.profile');
    }
    public function showMasterData()
    {
        return view('management.masterdata');
    }

    public function getDataKaryawan(Request $request){
        $filter = $request->all();
        $data =  $this->karyawan
        ->when(!empty($filter['nama_karyawan']), function ($query) use ($filter) {
            return $query->where('nama_karyawan', 'LIKE',"%{$filter['nama_karyawan']}%" );
        })
        ->when(!empty($filter['bagian']), function ($query) use ($filter) {
            return $query->where('bagian',$filter['bagian']);
        })
        ->when(!empty($filter['kode_karyawan']), function ($query) use ($filter) {
            return $query->where('kode_karyawan','LIKE',"%{$filter['kode_karyawan']}%" );
        })
        ->when(!empty($filter['group']), function ($query) use ($filter) {
            return $query->where('group',$filter['group']);
        })
        ->when(!empty($filter['pekerjaan']), function ($query) use ($filter) {
            return $query->where('pekerjaan',$filter['pekerjaan']);
        })->where('status',1)
        ->paginate(200);
        $group =  $this->group->get();
        $pekerjaan =  $this->pekerjaan->get();
        $bagian =  $this->bagian->get();
        $optionsbagian = [];
        $optionsgroup =[];
        $optionspekerjaan = [];
        foreach($bagian as $bag){
            $optionsbagian[] = $bag->name;
        }
        foreach($group as $grp){
            $optionsgroup[] = $grp->name;
        }
        foreach($pekerjaan as $pkj){
            $optionspekerjaan[] = $pkj->name;
        }
        return response()->json([
            'data' => $data,
            'optionsbagian' => $optionsbagian,
            'optionsgroup'  => $optionsgroup,
            'optionspekerjaan'  => $optionspekerjaan,
        ]);
    }

    public function getDataKaryawanByid(Request $request){
        $data =  $this->karyawan
        ->where('id',Hashids::decode($request->id))
        ->first();

        return response()->json([
            'data' => $data
        ]);
    }
    
    public function uploadFoto(Request $request){
        
        $datasubmit = json_decode($request->user);
        $id =  Hashids::decode($request->id);
    
       if($request->file('file') !== null){
            $path = 'public/images/foto/';
            $file = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            Storage::disk('local')->putFileAs($path, $file, $filename);
       }else{
            $filename = null;
       }
        $cek = $this->karyawan->where('id',$id)->first();

        if($cek){
            $data = $this->karyawan->where('id',$id)->first();
        }else{
            $data = $this->karyawan;
        }

        $data->kode_karyawan =  $datasubmit->kode_karyawan;
        $data->group         =  $datasubmit->group;
        $data->nama_karyawan =  $datasubmit->nama_karyawan;
        $data->pekerjaan     =  $datasubmit->pekerjaan;
        $data->bagian        =  $datasubmit->bagian;
        $data->foto          =  $filename;
        $data->save();
        

        return response()->json([
            'message'  => 'Sukses',
        ]);
        // return $datasubmit;
    }

    public function createMasterGroup(Request $request){

        if($request->id != null){
            $data =  $this->group
            ->where('id',Hashids::decode($request->id))->first();
            $data->name  = $request->nama_group;
            $data->save();
        }else{
            $data =  $this->group;
            $data->name  = $request->nama_group;
            $data->save();
        }
            return response()->json('Sukses');
    }
    public function getDataGroupByid(Request $request){
        $data =  $this->group
        ->where('id',Hashids::decode($request->id))
        ->first();

        return response()->json([
            'data' => $data
        ]);
    }
    public function deleteDataGroup(Request $request){
        $data =  $this->group->where('id',Hashids::decode($request->id))->first();
        $data->delete();
        return response()->json('Sukses Delete Data');
    }

    //action bagian
    public function getDayaBagian(){
        // all master
        $bagian =  $this->bagian->get();
        $group =  $this->group->get();
        $pekerjaan =  $this->pekerjaan->get();
       

        return response()->json([
            'group' => $group,
            'pekerjaan' => $pekerjaan,
            'bagian' => $bagian
        ]);
    }
    
    public function deleteDataBagian(Request $request){
        $data =  $this->bagian->where('id',Hashids::decode($request->id))->first();
        $data->delete();
        return response()->json('Sukses Delete Data');
    }
    public function getBagianByid(Request $request){
        $data =  $this->bagian->where('id',Hashids::decode($request->id))->first();
        return response()->json($data);
    }
    public function createMasterBagian(Request $request){

        if($request->id != null){
            $data =  $this->bagian
            ->where('id',Hashids::decode($request->id))->first();
            $data->name  = $request->nama_bagian;
            $data->save();
        }else{
            $data =  $this->bagian;
            $data->name  = $request->nama_bagian;
            $data->save();
        }
        return response()->json('Sukses');
    }

    public function createMasterPekerjaan(Request $request){

        if($request->id != null){
            $data =  $this->pekerjaan
            ->where('id',Hashids::decode($request->id))->first();
            $data->name  = $request->nama_pekerjaan;
            $data->save();
        }else{
            $data =  $this->pekerjaan;
            $data->name  = $request->nama_pekerjaan;
            $data->save();
        }
        return response()->json('Sukses');
    }
    public function getPekerjaanByid(Request $request){
        $data =  $this->pekerjaan->where('id',Hashids::decode($request->id))->first();
        return response()->json($data);
    }
    public function deleteDataPekerjaan(Request $request){
        $data =  $this->pekerjaan->where('id',Hashids::decode($request->id))->first();
        $data->delete();
        return response()->json('Sukses Delete Data');
    }

    public function nonAktifkanKaryawan(Request $request){
        $data =  $this->karyawan->where('id',Hashids::decode($request->id))->first();
        $data->status =  0;
        $data->save();
        if($data->save()){
            $pnj = $this->pinjaman->where('id_karyawan',Hashids::decode($request->id))->first();
            $pnj->status = 0;
            $pnj->save();
        }
        return response()->json('Sukses Delete Data');
    }
}
