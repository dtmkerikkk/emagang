<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;
//use App\Models\AdminModel;
use Ramsey\Uuid\Uuid;
use App\Controllers\BaseController;

class CRUDAnakMagang extends BaseController
{
    public function read()
    {

        $data['title'] = 'Anak Magang';
        $data['active_sidebar'] = 'anakmagang';
        // $data['instansi'] = $this->instansiModel->getInstansiJoin();
        $data['anakMagang'] = $this->anakMagangModel->getAnakMagangJoin();
        //dd($data);


        //dd($data);
        return view('/admin/anakMagang_view', $data);
    }

    public function deleteAnakMagang($id_magang)
    {
        $data = $this->anakMagangModel->find($id_magang);
        //dd($data);

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan: ' . $id_magang);
        }
        $status = $data['status_magang'];
        if ($status == 'nonmagang' || $status == 'tamat') {
            $this->anakMagangModel->table('anak_magang')->where('id_magang', $id_magang)->delete();
            //$this->adminModel->delete($id_admin);

            return redirect()->to('/admin/anakMagang_view/')->with('success', 'Data berhasil dihapus.');
        } else {
            return redirect()->back();
        }
    }

    public function change_status($id_magang)
    {
        // Ambil data dari database berdasarkan ID
        // dd($id_magang);
        $data = $this->anakMagangModel->find($id_magang);
        // Jika data tidak ditemukan, tampilkan halaman error 404
        // if (!$data) return $this->show_404();
        $status = $data['status'] == 'aktif' ? 'nonaktif' : 'aktif';

        // Update data di database
        $this->anakMagangModel->update($id_magang, ['status' => $status]);
        // Redirect kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Status berhasil  di update');
    }

    public function change_status_magang($id_magang)
    {
        // Ambil data dari database berdasarkan ID
        $data = $this->anakMagangModel->find($id_magang);
        // Jika data tidak ditemukan, tampilkan halaman error 404
        // if (!$data) return $this->show_404();
        $status_magang = $data['status_magang'] == 'nonmagang' ? 'magang' : ($data['status_magang'] == 'magang' ? 'tamat' : 'nonmagang');
        // Update data di database
        $this->anakMagangModel->update($id_magang, ['status_magang' => $status_magang]);
        // Redirect kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Status berhasil  di update');
    }
}
