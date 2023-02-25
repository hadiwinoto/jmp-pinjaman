<?php

namespace App\Http\Controllers\Rekap;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Kasbon\KelolaKasbonController;
use Illuminate\Http\Request;
use App\Models\Mkaryawan;
use App\Models\kasbon\MdataPinjaman;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class RekapKasbonController extends Controller
{
    public function __construct()
    {
        $this->karyawan             =  new Mkaryawan();
        $this->pinjaman             =  new MdataPinjaman();
        $this->file                 =  new Filesystem;
        $this->xlsReader            =  new Xls();
        $this->xlsxReader           = IOFactory::createReader("Xlsx");
    }
    public function downloadRekapAll(){
        $data = $this->karyawan
            ->with(array(
                'onePinjaman' => function ($query) {
                $query->select('id','id_karyawan','tanggal','sisa_pinjaman','jenis');
                }
            ))
            ->where('status',1)
            ->get();

        $pinjaman =  $this->pinjaman->get();

        $totalpinjaman   = 0;
        $totalpembayaran = 0;
        foreach($pinjaman as $pnj){
            $totalpinjaman+= $pnj->tambah_pinjaman;
            $totalpembayaran+= $pnj->pembayaran;
        }
        $totalpiutang = $totalpinjaman;

        $template = 'template-rekap-all.xls';
        $pathtemplate = "storage/template/$template";
        $doc = $this->xlsReader->load($pathtemplate);
        $doc->getActiveSheet(0);
        $cov = $doc->setActiveSheetIndex(0);
        $row = 8;
        $no = 0;
        foreach($data as $dta){
            $cov->setCellValue('B' . $row, $no+1);
            $cov->setCellValue('C' . $row, $dta->kode_karyawan);
            $cov->setCellValue('D' . $row, $dta->nama_karyawan);
            $cov->setCellValue('E' . $row, $dta->group);
            $cov->setCellValue('F' . $row, $dta->pekerjaan);
            $cov->setCellValue('G' . $row, $dta->bagian);
            $cov->setCellValue('H' . $row, $dta->onePinjaman    ==  null ? '-' :  $dta->onePinjaman['tanggal']);
            $cov->setCellValue('I' . $row, $dta->onePinjaman    ==  null ? '-' :  $dta->onePinjaman['jenis']);
            $cov->setCellValue('J' . $row, $dta->onePinjaman    ==  null ? '-' :  $dta->onePinjaman['sisa_pinjaman']);
            $cov->getRowDimension($row)->setVisible(true);
            $row++;
            $no++;
        }

        $cov->setCellValue('D6',$totalpiutang);

        $date = Carbon::now()->format('d-m-Y');
        $writer = IOFactory::createWriter($doc, "Xlsx");
        $filename = 'Rekap Data '.'-'. $date . '.xlsx';
        
        $filepath = "storage/files/temp/$filename";
        $writer->save($filepath);
        return redirect($filepath);
        return response()->json($data);
    }


    public function downloadRekapById(Request $request){
        $karyawan = $this->karyawan->where('id',Hashids::decode($request->id))->first();
        $datapinjaman = $this->pinjaman->where('id_karyawan',Hashids::decode($request->id))
            ->orderBy('id','desc')
            ->get();
        $datapiutang = $this->pinjaman
            ->where('id_karyawan',Hashids::decode($request->id))
            ->where('status',1)->get();
        $totalpinjaman   = 0;
        $totalpembayaran = 0;
        foreach($datapiutang as $pnj){
            $totalpinjaman+= $pnj->tambah_pinjaman;
            $totalpembayaran+= $pnj->pembayaran;
        }
        $sisapiutang = $totalpinjaman - $totalpembayaran;

            
        $template = 'template-rekap-individu.xls';
        $pathtemplate = "storage/template/$template";
        $doc = $this->xlsReader->load($pathtemplate);
        $doc->getActiveSheet(0);
        $cov = $doc->setActiveSheetIndex(0);


        $cov->setCellValue('D6',$karyawan->kode_karyawan);
        $cov->setCellValue('D7',$karyawan->nama_karyawan);
        $cov->setCellValue('D8',$karyawan->pekerjaan);
        $cov->setCellValue('D9',$karyawan->bagian);
        $cov->setCellValue('D10',$sisapiutang);

        $row = 13;
        $no = 0;
            foreach($datapinjaman as $dta){
                $cov->setCellValue('B' . $row, $no+1);
                $cov->setCellValue('C' . $row, $dta->tanggal);
                $cov->setCellValue('D' . $row, $dta->jenis);
                $cov->setCellValue('E' . $row, $dta->keterangan);
                $cov->setCellValue('F' . $row, $dta->tambah_pinjaman ==  0 ? '-' :  $dta->tambah_pinjaman);
                $cov->setCellValue('G' . $row, $dta->pembayaran ==  0 ? '-' :  $dta->pembayaran);
                $cov->setCellValue('H' . $row, $dta->sisa_pinjaman    ==  null ? '-' :  $dta->sisa_pinjaman);
                $cov->getRowDimension($row)->setVisible(true);
                $row++;
                $no++;
            }
    
            // $cov->setCellValue('D6',$totalpiutang);
    
            $writer = IOFactory::createWriter($doc, "Xlsx");
            $filename = 'Rekap Data'.' - '.$karyawan->nama_karyawan . '.xlsx';
            
            $filepath = "storage/files/temp/$filename";
            $writer->save($filepath);
            return redirect($filepath);
            // return response()->json([
            //     'datapinjaman' => $datapinjaman,
            //     'karyawan'     => $karyawan,
            // ]);
    }
    public function cleanTemp()
	{
		$this->file->cleanDirectory('storage/files/temp');
	}
    public function dataDashboard(){
        $datapiutang = $this->pinjaman->where('status',1)->get();
        $totalpinjaman   = 0;
        $totalpembayaran = 0;
        foreach($datapiutang as $pnj){
            $totalpinjaman+= $pnj->tambah_pinjaman;
            $totalpembayaran+= $pnj->pembayaran;
        }

        $sisapiutang = $totalpinjaman;
        $pinjamanterbesar = [];
        foreach($datapiutang as $kry){
            $pinjamanterbesar[] = [
                'nominal_kasbon' => $kry->tambah_pinjaman,
                'tanggal'        => $kry->tanggal,
            ];
        }
        
        $pinjamanterakhir = 0;

        return response()->json([
            'totalpiutang'      => $sisapiutang,
            'pinjamanterbesar'  => max($pinjamanterbesar),
            'pinjamanterakhir'  => $pinjamanterbesar[0],
        ]);

    }
}
