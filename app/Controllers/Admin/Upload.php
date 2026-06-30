<?php

namespace App\Controllers\Admin;

class Upload extends BaseController
{
    public function index()
    {
        // Mendapatkan file yang diunggah
        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi jenis file agar hanya gambar
            $mimeType = $file->getMimeType();
            $allowedMimes = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/webp'];

            if (!in_array($mimeType, $allowedMimes)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Jenis file tidak diizinkan. Hanya file gambar (JPG, JPEG, PNG, GIF, WEBP) yang diperbolehkan.'
                ]);
            }

            // Generate nama acak baru agar tidak bentrok
            $newName = $file->getRandomName();

            // Pindahkan file ke folder assets/upload/image
            $targetDir = WRITEPATH . '../assets/upload/image/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $file->move($targetDir, $newName);

            // Kompresi otomatis gambar untuk menghemat penyimpanan server
            $this->compressImage($targetDir . $newName);

            // Response URL gambar untuk TinyMCE
            $fileUrl = base_url('assets/upload/image/' . $newName);

            return $this->response->setJSON([
                'location' => $fileUrl
            ]);
        }

        return $this->response->setStatusCode(400)->setJSON([
            'error' => 'Gagal mengunggah gambar. Pastikan file valid.'
        ]);
    }
}
