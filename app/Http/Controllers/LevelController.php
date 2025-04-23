<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
class LevelController extends Controller
{
    public function index()
    {
        return view('level.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar level pengguna',
                'list' => ['Home', 'Level']
            ],
            'level' => LevelModel::all(),
            'page' => (object) [
                'title' => 'Daftar level pengguna yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'level'
        ]);
    }

    public function list(Request $req) 
    {
        $level = LevelModel::select( 'level_id', 'level_kode', 'level_name');

        if ($req->level_id) {
            $level->where('level_id', $req->level_id);
        }

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $detailUrl = route('level.show', ['id' => $level->level_id]);
                $editUrl = route('level.edit-ajax', ['id' => $level->level_id]);
                $deleteAjax = route('level.delete-ajax', ['id' => $level->level_id]);
                
                return <<<HTML
                <button onclick="modalAction('{$detailUrl}')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$editUrl}')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$deleteAjax}')" class="btn btn-danger btn-sm">Hapus</button>
                HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    public function create()
    {
        return view('level.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Level Pengguna',
                'list' => ['Home', 'Level', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah level pengguna baru'
            ],
            'activeMenu' => 'level'
        ]);
    }

    public function createAjax()
    {
        return view('level.create-ajax');
    }

    public function store(Request $req)
    {
        $req->validate([
            'level_kode' => "required|string|min:3|unique:m_level,level_kode",
            'level_name' => 'required|string|max:100|unique:m_level,level_name'
        ]);

        LevelModel::create([
            'level_kode' => $req->level_kode,
            'level_name' => $req->level_name
        ]);

        return redirect('/level')
            ->with('success', 'Data level pengguna berhasil disimpan!');
    }

    public function storeAjax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            redirect('/');
        }
        
        $validator = Validator::make($req->all(), [
            'level_kode' => "required|string|min:3|unique:m_level,level_kode",
            'level_name' => 'required|string|max:100|unique:m_level,level_name'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        LevelModel::create($req->all());

        return response()->json([
            'message' => 'Data level berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function show(string $id)
    {
        return view('level.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Level',
                'list' => ['Home', 'Level', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail level'
            ],
            'level' => LevelModel::find($id),
            'activeMenu' => 'level'
        ]);
    }

    public function edit(string $id)
    {
        return view('level.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit level',
                'list' => ['Home', 'Level', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit level'
            ],
            'level' => LevelModel::find($id),
            'activeMenu' => 'level'
        ]);
    }

    public function editAjax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.edit-ajax', [
            'level' => $level
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'level_kode' => "required|string|min:3|unique:m_level,level_kode,$id,level_id",
            'level_name' => 'required|string|max:100'
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $req->level_kode,
            'level_name' => $req->level_name
        ]);

        return redirect('/level')
            ->with('success', 'Data berhasil diubah');
    }

    public function updateAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($req->all(), [
            'level_kode' => "required|string|min:3|unique:m_level,level_kode,$id,level_id",
            'level_name' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $level = LevelModel::find($id);

        if (!$level) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$req->filled('password')) {
            $req->request->remove('password');
        }

        $level->update($req->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $check = LevelModel::find($id);

        if (!$check) {
            return redirect('/level')->with('error', 'Data level pengguna tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);

            return redirect('/level')
                ->with('success', 'Data level pengguna berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/level')
                ->with('error', 'Data level pengguna gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirmDeleteAjax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.confirm-delete-ajax', ['level' => $level]);
    }

    public function deleteAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $level = LevelModel::find($id);

        if (!$level) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $level->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], Response::HTTP_OK);
    }

    public function showImportModal()
    {
        return view('level.import-excel');
    }

    public function importDataExcel(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $rules = [
            'file_level' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $file = $req->file('file_level');

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();

        $data = $sheet->toArray(null, false, true, true);

        $insert = [];
        if (count($data) <= 1) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ], Response::HTTP_BAD_REQUEST);
        }

        foreach ($data as $row => $val) {
            if ($row > 1) {
                $insert[] = [
                    'level_kode' => $val['A'],
                    'level_name' => $val['B'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        if (count($insert) > 0) {
            LevelModel::insertOrIgnore($insert);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diimport'
        ], Response::HTTP_OK);
    }

    public function exportExcel()
    {
        $level = LevelModel::select('level_kode', 'level_name')
            ->orderBy('level_kode')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Level Kode')
            ->setCellValue('C1', 'Level Nama');
        
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $no = 1;
        $row = 2;

        foreach ($level as $key => $value) {
            $sheet->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $value->level_kode)
                ->setCellValue('C' . $row, $value->level_name);
            $row++;
        }
        
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Level');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Level ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $level = LevelModel::select('level_kode', 'level_name')
            ->orderBy('level_kode')
            ->get();

        $pdf = Pdf::loadView('level.export-pdf', [ 'level' => $level ])
                ->setPaper('A4', 'landscape')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true);
        
        $pdf->render();

        return $pdf->stream('Data Supplier ' . date('Y-m-d H-i-s') . '.pdf');
    }
}
