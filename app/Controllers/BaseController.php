<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Simple_login;
use App\Libraries\Website;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form','website', 'text', 'onesignal'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->session          = \Config\Services::session();
        $this->db               = \Config\Database::connect();
        $this->pager            = \Config\Services::pager();
        $uri                    = service('uri');
        $this->simple_login     = new Simple_login(); 
        $this->website          = new Website(); 
    }

    protected function sendEmail($to, $subject, $messageHtml)
    {
        if (empty($to)) {
            return false;
        }

        $m_konfigurasi = new \App\Models\Konfigurasi_model();
        $konfigurasi = $m_konfigurasi->listing();

        if (empty($konfigurasi->smtp_user)) {
            return false;
        }

        $email_config = [
            'protocol'    => $konfigurasi->protocol ?? 'smtp',
            'SMTPHost'    => $konfigurasi->smtp_host ?? '',
            'SMTPUser'    => $konfigurasi->smtp_user ?? '',
            'SMTPPass'    => $konfigurasi->smtp_pass ?? '',
            'SMTPPort'    => (int) ($konfigurasi->smtp_port ?? 587),
            'SMTPTimeout' => (int) ($konfigurasi->smtp_timeout ?? 5),
            'SMTPCrypto'  => $konfigurasi->smtp_crypto ?? '',
            'mailType'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'CRLF'        => "\r\n"
        ];

        $email_service = \Config\Services::email();
        $email_service->initialize($email_config);
        $email_service->setFrom($konfigurasi->smtp_user, $this->website->namaweb());
        $email_service->setReplyTo($konfigurasi->smtp_user, $this->website->namaweb());
        $email_service->setTo((string) $to);
        $email_service->setSubject($subject);

        $email_service->setHeader('Organization', $this->website->namaweb());
        $email_service->setHeader('X-Priority', '3'); // Normal
        $email_service->setHeader('X-Mailer', 'PHP/' . phpversion());

        $email_service->setMessage($messageHtml);
        
        $message_text = strip_tags(str_replace(['<br>', '<li>', '</ul>', '</p>'], ["\n", "- ", "\n", "\n\n"], $messageHtml));
        $email_service->setAltMessage($message_text);

        if ($email_service->send()) {
            return true;
        } else {
            log_message('error', 'SMTP Error sending to ' . $to . '. Detail: ' . $email_service->printDebugger(['headers', 'subject', 'body']));
            return false;
        }
    }

    protected function getWaliData()
    {
        $identitas_wali = $this->request->getPost('identitas_wali');
        if ($identitas_wali == 'Ayah') {
            return [
                'id_agama_wali'       => $this->request->getPost('id_agama_ayah'),
                'id_pekerjaan_wali'   => $this->request->getPost('id_pekerjaan_ayah'),
                'id_jenjang_wali'     => $this->request->getPost('id_jenjang_ayah'),
                'nama_wali'           => $this->request->getPost('nama_ayah'),
                'alamat_wali'         => $this->request->getPost('alamat_ayah'),
                'telepon_wali'        => $this->request->getPost('telepon_ayah'),
                'rt_wali'             => $this->request->getPost('rt_ayah'),
                'rw_wali'             => $this->request->getPost('rw_ayah'),
                'kelurahan_wali'      => $this->request->getPost('kelurahan_ayah'),
                'kecamatan_wali'      => $this->request->getPost('kecamatan_ayah'),
                'kabupaten_wali'      => $this->request->getPost('kabupaten_ayah'),
                'provinsi_wali'       => $this->request->getPost('provinsi_ayah'),
                'kode_pos_wali'       => $this->request->getPost('kode_pos_ayah'),
                'tempat_lahir_wali'   => $this->request->getPost('tempat_lahir_ayah'),
                'tanggal_lahir_wali'  => $this->request->getPost('tanggal_lahir_ayah'),
                'status_wn_wali'      => $this->request->getPost('status_wn_ayah'),
                'penghasilan_wali'    => $this->request->getPost('penghasilan_ayah'),
            ];
        } elseif ($identitas_wali == 'Ibu') {
            return [
                'id_agama_wali'       => $this->request->getPost('id_agama_ibu'),
                'id_pekerjaan_wali'   => $this->request->getPost('id_pekerjaan_ibu'),
                'id_jenjang_wali'     => $this->request->getPost('id_jenjang_ibu'),
                'nama_wali'           => $this->request->getPost('nama_ibu'),
                'alamat_wali'         => $this->request->getPost('alamat_ibu'),
                'telepon_wali'        => $this->request->getPost('telepon_ibu'),
                'rt_wali'             => $this->request->getPost('rt_ibu'),
                'rw_wali'             => $this->request->getPost('rw_ibu'),
                'kelurahan_wali'      => $this->request->getPost('kelurahan_ibu'),
                'kecamatan_wali'      => $this->request->getPost('kecamatan_ibu'),
                'kabupaten_wali'      => $this->request->getPost('kabupaten_ibu'),
                'provinsi_wali'       => $this->request->getPost('provinsi_ibu'),
                'kode_pos_wali'       => $this->request->getPost('kode_pos_ibu'),
                'tempat_lahir_wali'   => $this->request->getPost('tempat_lahir_ibu'),
                'tanggal_lahir_wali'  => $this->request->getPost('tanggal_lahir_ibu'),
                'status_wn_wali'      => $this->request->getPost('status_wn_ibu'),
                'penghasilan_wali'    => $this->request->getPost('penghasilan_ibu'),
            ];
        } else {
            return [
                'id_agama_wali'       => $this->request->getPost('id_agama_wali'),
                'id_pekerjaan_wali'   => $this->request->getPost('id_pekerjaan_wali'),
                'id_jenjang_wali'     => $this->request->getPost('id_jenjang_wali'),
                'nama_wali'           => $this->request->getPost('nama_wali'),
                'alamat_wali'         => $this->request->getPost('alamat_wali'),
                'telepon_wali'        => $this->request->getPost('telepon_wali'),
                'rt_wali'             => $this->request->getPost('rt_wali'),
                'rw_wali'             => $this->request->getPost('rw_wali'),
                'kelurahan_wali'      => $this->request->getPost('kelurahan_wali'),
                'kecamatan_wali'      => $this->request->getPost('kecamatan_wali'),
                'kabupaten_wali'      => $this->request->getPost('kabupaten_wali'),
                'provinsi_wali'       => $this->request->getPost('provinsi_wali'),
                'kode_pos_wali'       => $this->request->getPost('kode_pos_wali'),
                'tempat_lahir_wali'   => $this->request->getPost('tempat_lahir_wali'),
                'tanggal_lahir_wali'  => $this->request->getPost('tanggal_lahir_wali'),
                'status_wn_wali'      => $this->request->getPost('status_wn_wali'),
                'penghasilan_wali'    => $this->request->getPost('penghasilan_wali'),
            ];
        }
    }

    protected function logActivity($kategori, $aktivitas)
    {
        $m_log = new \App\Models\Log_model();
        $session = \Config\Services::session();
        
        $data = [
            'id_user'     => $session->get('id_user') ?: null,
            'username'    => $session->get('username') ?: null,
            'kategori'    => $kategori,
            'aktivitas'   => $aktivitas,
            'ip_address'  => $this->request->getIPAddress(),
            'tanggal_log' => date('Y-m-d H:i:s')
        ];
        
        $m_log->tambah($data);
    }

    /**
     * Memperkecil dimensi dan mengompres ukuran file gambar secara otomatis
     * @param string $path Path file gambar yang sudah dipindahkan (diupload)
     * @param int $quality Kualitas kompresi (1-100)
     * @param int $maxWidth Lebar maksimum
     * @param int $maxHeight Tinggi maksimum
     */
    protected function compressImage($path, $quality = 60, $maxWidth = 1200, $maxHeight = 1200)
    {
        if (!file_exists($path)) {
            return false;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        // Hanya kompres file berjenis gambar standar
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            try {
                $image = \Config\Services::image()->withFile($path);
                
                // Ambil info gambar untuk mengecek ukurannya
                $info = getimagesize($path);
                if ($info) {
                    $width = $info[0];
                    $height = $info[1];
                    
                    // Jika dimensi asli lebih besar dari maksimal, resize sambil mempertahankan rasio
                    if ($width > $maxWidth || $height > $maxHeight) {
                        $image->resize($maxWidth, $maxHeight, true, 'auto');
                    }
                }
                
                // Simpan/timpa file dengan kualitas kompresi untuk menekan ukuran file
                $image->withResource()->save($path, $quality);
                return true;
            } catch (\Exception $e) {
                // Biarkan saja jika gagal kompresi (misalnya file rusak/tidak didukung library)
                return false;
            }
        }
        return false;
    }
}
