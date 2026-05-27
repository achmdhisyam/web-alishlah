<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Ai extends BaseController
{
    public function kembangkanBerita()
    {
        // Pastikan hanya menerima request AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Akses ditolak.']);
        }

        $judul = $this->request->getPost('judul');
        $draft_isi = $this->request->getPost('draft_isi');

        if (empty($judul) || empty($draft_isi)) {
            return $this->response->setJSON(['error' => 'Judul dan poin inti berita tidak boleh kosong.']);
        }

        // Ambil API Key dari .env (variabel GEMINI_API_KEY)
        $apiKey = getenv('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return $this->response->setJSON(['error' => 'API Key Gemini belum disetel di file .env']);
        }

        // Prompt: AI buatkan judul, isi, dan ringkasan sekaligus
        $prompt = "Saya adalah seorang admin website madrasah. Tolong bantu saya membuat artikel berita madrasah yang lengkap berdasarkan poin-poin berikut.\n\n"
                . "Judul Referensi (boleh diubah/dikembangkan): " . ($judul ?: '(kosong, buatkan sendiri)') . "\n"
                . "Poin-poin Inti:\n" . $draft_isi . "\n\n"
                . "Tugas Anda:\n"
                . "1. Buatkan judul berita yang menarik, informatif, dan profesional.\n"
                . "2. Kembangkan poin-poin menjadi artikel berita minimal 3 paragraf (gunakan tag HTML <p></p> untuk tiap paragraf).\n"
                . "3. Buatkan ringkasan berita sepanjang 1-2 kalimat.\n\n"
                . "Format output yang wajib Anda hasilkan adalah JSON seperti ini:\n"
                . '{"judul": "Judul Berita", "isi": "<p>paragraf 1</p><p>paragraf 2...</p>", "ringkasan": "teks ringkasan"}';

        // URL Endpoint API Gemini menggunakan model gemini-2.5-flash-lite
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=' . $apiKey;

        // Payload standard dengan responseMimeType
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'responseMimeType' => 'application/json'
            ]
        ];

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
                'http_errors' => false // Agar menangkap status error manual
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            if ($statusCode !== 200) {
                $errorMsg = $body['error']['message'] ?? 'Unknown API error';
                return $this->response->setJSON(['error' => 'Error dari API AI: ' . $errorMsg]);
            }

            // Membaca teks mentah hasil generate dari struktur objek respons Gemini
            $aiRawText = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            if (empty($aiRawText)) {
                return $this->response->setJSON(['error' => 'AI memberikan respon kosong.']);
            }

            // Parsing teks mentah
            $result = json_decode(trim($aiRawText), true);

            if (!$result || !isset($result['isi']) || !isset($result['ringkasan']) || !isset($result['judul'])) {
                // Fallback jika AI salah format
                return $this->response->setJSON([
                    'error' => 'Format JSON dari AI tidak sesuai dengan struktur {"judul": "...", "isi": "...", "ringkasan": "..."}.',
                    'raw_output' => $aiRawText // untuk mempermudah debugging Anda
                ]);
            }

            // Kembalikan hasil sukses ke AJAX
            return $this->response->setJSON([
                'success' => true,
                'judul' => $result['judul'],
                'isi' => $result['isi'],
                'ringkasan' => $result['ringkasan']
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
}
