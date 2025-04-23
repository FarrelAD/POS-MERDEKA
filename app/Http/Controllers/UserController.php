<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar user',
                'list' => ['Home', 'User']
            ],
            'level' => LevelModel::all(),
            'page' => (object) [
                'title' => 'Daftar user yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'user'
        ]);
    }

    public function list(Request $req) 
    {
        $users = User::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        
            if ($req->level_id) {
            $users->where('level_id', $req->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $detailUrl = route('user.show', ['id' => $user->user_id]);
                $editUrl = route('user.edit-ajax', ['id' => $user->user_id]);
                $deleteAjax = route('user.delete-ajax', ['id' => $user->user_id]);
                
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
        return view('user.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah User',
                'list' => ['Home', 'User', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah user baru'
            ],
            'level' => LevelModel::all(),
            'activeMenu' => 'user'
        ]);
    }

    public function createAjax()
    {
        return view('user.create-ajax')
            ->with('levels', LevelModel::select('level_id', 'level_name')->get());
    }

    public function store(Request $req)
    {
        $req->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        User::create([
            'username' => $req->username,
            'nama' => $req->nama,
            'password' => bcrypt($req->password),
            'level_id' => $req->level_id
        ]);

        return redirect('/user')
            ->with('success', 'Data user berhasil disimpan!');
    }

    public function storeAjax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            redirect('/');
        }
        
        $validator = Validator::make($req->all(), [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        User::create($req->all());

        return response()->json([
            'message' => 'Data user berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function show(string $id)
    {
        return view('user.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail User',
                'list' => ['Home', 'User', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail user'
            ],
            'user' => User::with('level')->find($id),
            'activeMenu' => 'user'
        ]);
    }

    public function edit(string $id)
    {
        return view('user.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit User',
                'list' => ['Home', 'User', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit User'
            ],
            'user' => User::find($id),
            'level' =>LevelModel::all(),
            'activeMenu' => 'user'
        ]);
    }

    public function editAjax(string $id)
    {
        $user = User::find($id);
        $levels = LevelModel::select('level_id', 'level_name')->get();

        return view('user.edit-ajax', [
            'user' => $user,
            'levels' => $levels
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'username' => "required|string|min:3|unique:m_user,username,$id,user_id",
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        User::find($id)->update([
            'username' => $req->username,
            'nama' => $req->nama,
            'password' => $req->password ? bcrypt($req->password) : User::find($id)->password,
            'level_id' => $req->level_id
        ]);

        return redirect('/user')
            ->with('success', 'Data berhasil diubah');
    }

    public function updateAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($req->all(), [
            'level_id' => 'required|integer',
            'username' => "required|max:20|unique:m_user,username,$id,user_id",
            'nama' => 'required|max:100',
            'password' => 'nullable|min:6|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$req->filled('password')) {
            $req->request->remove('password');
        }

        $user->update($req->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $check = User::find($id);

        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            User::destroy($id);

            return redirect('/user')
                ->with('success', 'Data user berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/user')
                ->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirmDeleteAjax(string $id)
    {
        $user = User::find($id);

        return view('user.confirm-delete-ajax', ['user' => $user]);
    }

    public function deleteAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], Response::HTTP_OK);
    }

    public function showUserProfile()
    {
        return view('user.profile', [
            'breadcrumb' => (object) [
                'title' => 'Profil',
                'list' => ['Home', 'Profile']
            ],
            'page' => (object) [
                'title' => 'Profile'
            ],
            'user' => auth()->user(),
            'activeMenu' => 'profile'
        ]);
    }

    public function updateUserPhotoProfile(Request $req)
    {
        if (!$req->hasFile('photo') && !$req->file('photo')->isValid()) {
            return response()->json([
                "message" => "Image file is invalid"
            ], Response::HTTP_BAD_REQUEST);
        }

        $img = $req->file('photo');
        $path = $img->store('public/img');
        $filename = basename($path);

        $user = Auth::user();
        $user->photo_profile = $filename;
        $user->save();

        return response()->json([
            "message" => "Successfully update user photo profile",
        ], Response::HTTP_OK);
    }

    public function showImportModal()
    {
        return view('user.import-excel');
    }

    public function importDataExcel(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $rules = [
            'file_user' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $file = $req->file('file_user');

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
                    'level_id' => $val['A'],
                    'username' => $val['B'],
                    'nama' => $val['C'],
                    'password' => bcrypt($val['D']),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        if (count($insert) > 0) {
            User::insertOrIgnore($insert);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diimport'
        ], Response::HTTP_OK);
    }

    public function exportExcel()
    {
        $user = User::select('level_id', 'username', 'nama')
            ->orderBy('level_id')
            ->with('level')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Level Kode')
            ->setCellValue('C1', 'Username')
            ->setCellValue('D1', 'Nama');
        
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $no = 1;
        $row = 2;

        foreach ($user as $key => $value) {
            $sheet->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $value->level->level_kode)
                ->setCellValue('C' . $row, $value->username)
                ->setCellValue('D' . $row, $value->nama);
            $row++;
        }
        
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Pengguna');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Pengguna ' . date('Y-m-d H-i-s') . '.xlsx';

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
        $user = User::select('level_id', 'username', 'nama')
            ->orderBy('level_id')
            ->with('level')
            ->get();

        $pdf = Pdf::loadView('user.export-pdf', [ 'user' => $user ])
                ->setPaper('A4', 'landscape')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true);
        
        $pdf->render();

        return $pdf->stream('Data Pengguna ' . date('Y-m-d H-i-s') . '.pdf');
    }
}
