<?php

namespace App\Http\Controllers\Kasbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mkaryawan;
use App\Models\kasbon\MdataPinjaman;
use App\Models\Mpekerjaan;
use App\Models\Mgroup;
use App\Models\Mbagian;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;

class KelolaKasbonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->karyawan = new Mkaryawan();
        $this->pinjaman = new MdataPinjaman();
        $this->group    = new Mgroup();
        $this->pekerjaan =  new Mpekerjaan();
        $this->bagian    = new Mbagian();
    }
    public function index($component = "kasbon")
    {
        return view('kasbon.kasbon', compact('component'));
    }
    public function show($group, $component, $id = "")
    {
        return view('kasbon.kasbon', compact('group', 'component', "id"));
    }
    public function showDetail()
    {
        return view('kasbon.detail');
    }
    //api data
    public function getDataKaryawan(Request $request){
        $filter = $request->all();
        $data = $this->karyawan
                ->with(array(
                    'onePinjaman' => function ($query) {
                    $query->select('id','id_karyawan','tanggal','sisa_pinjaman');
                    }
                ))
                // ->with('onePinjaman')
                ->when(!empty($filter['nama_karyawan']), function ($query) use ($filter) {
                    return $query->where('nama_karyawan', 'LIKE',"%{$filter['nama_karyawan']}%" );
                })
                ->when(!empty($filter['pekerjaan']), function ($query) use ($filter) {
                    return $query->where('pekerjaan',$filter['pekerjaan']);
                })
                ->when(!empty($filter['group']), function ($query) use ($filter) {
                    return $query->where('group',$filter['group']);
                })
                ->when(!empty($filter['bagian']), function ($query) use ($filter) {
                    return $query->where('bagian',$filter['bagian']);
                })
                ->when(!empty($filter['kode_karyawan']), function ($query) use ($filter) {
                    return $query->where('kode_karyawan',$filter['kode_karyawan']);
                })
                ->where('status',1)->orderBy('created_at', 'desc')
                ->paginate(40);

        $datapiutang = $this->pinjaman->where('status',1)->get();
        $totalpinjaman   = 0;
        $totalpembayaran = 0;
        foreach($datapiutang as $pnj){
            $totalpinjaman+= $pnj->tambah_pinjaman;
            $totalpembayaran+= $pnj->pembayaran;
        }
        $totalpiutang  = $totalpinjaman;
        $totalterbayar = $totalpembayaran;

        $group =  $this->group->get();
        $pekerjaan =  $this->pekerjaan->get();
        $bagian =  $this->bagian->get();

        $optionsgroup =[];
        $optionspekerjaan = [];
        $optionsbagian = [];

        foreach($group as $grp){
            $optionsgroup[] = $grp->name;
        }
        foreach($pekerjaan as $pkj){
            $optionspekerjaan[] = $pkj->name;
        }
        foreach($bagian as $bag){
            $optionsbagian[] = $bag->name;
        }
            
        return response()->json([
            'data' => $data,
            'totalpiutang'  => $totalpiutang,
            'totalterbayar' => $totalterbayar,
            'optionsgroup'  => $optionsgroup,
            'optionspekerjaan'  => $optionspekerjaan,
            'optionsbagian' => $optionsbagian,
        ]);
    }

    public function getRincianPinjaman(Request $request){

        $karyawan = $this->karyawan->where('id',Hashids::decode($request->id_karyawan))->first();
        $datapinjaman = $this->pinjaman->where('id_karyawan',Hashids::decode($request->id_karyawan))->orderBy('tanggal', 'desc')->paginate(200);
        $datapiutang = $this->pinjaman->where('id_karyawan',Hashids::decode($request->id_karyawan))->get();
        $totalpinjaman   = 0;
        $totalpembayaran = 0;
        foreach($datapiutang as $pnj){
            $totalpinjaman+= $pnj->tambah_pinjaman;
            $totalpembayaran+= $pnj->pembayaran;
        }
        $sisapiutang = $totalpinjaman - $totalpembayaran;
        return response()->json([
            'pinjaman' => $datapinjaman,
            'karyawan' => $karyawan,
            'sisa_piutang' => $sisapiutang
        ]);
    }
    public function submitKasbonLangsung(Request $request){
        $nilaipinjaman = 0;
        $cekpinjam = $this->pinjaman
                    ->where('id_karyawan',Hashids::decode($request->id_karyawan))
                    ->where('status',1)
                    ->sum('tambah_pinjaman');
        $cekbayar  = $this->pinjaman
                    ->where('id_karyawan',Hashids::decode($request->id_karyawan))
                    ->where('status',1)
                    ->sum('pembayaran');

        if($cekpinjam < 1){
            $nilaipinjaman = $request->data['tambah_pinjaman'];
        }else{
            $nilaipinjaman = ($cekpinjam - $cekbayar) + $request->data['tambah_pinjaman'];
        }
        $pinjaman = $this->pinjaman;
        $pinjaman->id_karyawan       =  Hashids::decode($request->id_karyawan)[0];
        $pinjaman->tanggal           =  Carbon::parse($request->data['tanggal'])->format('y-m-d');
        $pinjaman->jenis             =  'Pinjaman Langsung';
        $pinjaman->tambah_pinjaman   =  $request->data['tambah_pinjaman'];
        $pinjaman->keterangan        =  $request->data['keterangan'];
        $pinjaman->sisa_pinjaman     =  $nilaipinjaman;
        $pinjaman->save();

        return response()->json([
            // 'karyawan' => $karyawan,
            'pinjaman'      => $pinjaman,
            'nilaipinjaman' => $nilaipinjaman
        ]);
    }

    public function submitBayarLangsung(Request $request){
        $nilaipinjaman = 0;
        $cekpinjam = $this->pinjaman->where('id_karyawan',Hashids::decode($request->id_karyawan))->sum('tambah_pinjaman');
        $cekbayar = $this->pinjaman->where('id_karyawan',Hashids::decode($request->id_karyawan))->sum('pembayaran');

        if($cekpinjam < 1){
            $nilaipinjaman = 0;
        }else{
            $nilaipinjaman = ($cekpinjam - $cekbayar) - $request->data['pembayaran'];
        }

        $pinjaman = $this->pinjaman;
        $pinjaman->id_karyawan       =  Hashids::decode($request->id_karyawan)[0];
        $pinjaman->tanggal           =  Carbon::parse($request->data['tanggal'])->format('y-m-d');
        $pinjaman->jenis             =  'Bayar Langsung';
        $pinjaman->pembayaran        =  $request->data['pembayaran'];
        $pinjaman->keterangan        =  $request->data['keterangan'];
        $pinjaman->sisa_pinjaman     =  $nilaipinjaman;
        $pinjaman->save();


        return response()->json([
            'pinjaman' => $pinjaman
            // 'cekpinjaman' => $cek
        ]);
    }

    public function editKasbon(Request $request){
        $pinjaman = $this->pinjaman->where('id',Hashids::decode($request->id))->first();

        return response()->json([
            'data' => $pinjaman,
            'pembayaran' => $pinjaman->pembayaran,
            'sisa_pinjaman_terakhir' => $pinjaman->sisa_pinjaman
        ]);
    }

    public function submitEditKasbon(Request $request){
        $data = $this->pinjaman
            ->where('id',Hashids::decode($request->data['hashid']))
            ->first();
        $jenis =  $data->jenis;
        $data->delete();
        if($jenis === 'Pinjaman Langsung'){
            $this->submitKasbonLangsung($request);
        }else{
            $this->submitBayarLangsung($request);
        }
        // return $jenis;
        return response()->json([
            'data' => $data,
        ]);
    }

    public function deleteDataPinjaman(Request $request){
        $data = $this->pinjaman
            ->where('id',Hashids::decode($request->id))
            ->first();

        $data->delete();

        return response()->json([
            'message' => 'Sukses delete Data'
        ]);
    }

}
