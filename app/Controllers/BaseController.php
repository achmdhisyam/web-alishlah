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
    protected $helpers = ['form','website', 'text'];

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
        $email_service->setReplyTo($konfigurasi->email ?? $konfigurasi->smtp_user, $this->website->namaweb());
        $email_service->setTo((string) $to);
        $email_service->setSubject($subject);

        $email_service->setHeader('Organization', $this->website->namaweb());
        $email_service->setHeader('X-Priority', '3'); // Normal
        $email_service->setHeader('X-Mailer', 'PHP/' . phpversion());

        $email_service->setMessage($messageHtml);
        
        $message_text = strip_tags(str_replace(['<br>', '<li>', '</ul>', '</p>'], ["\n", "- ", "\n", "\n\n"], $messageHtml));
        $email_service->setAltMessage($message_text);

        return $email_service->send();
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
