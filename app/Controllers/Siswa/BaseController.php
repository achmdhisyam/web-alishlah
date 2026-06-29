<?php

namespace App\Controllers\Siswa;

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
        $this->simple_login->checklogin_siswa();
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
        $email_service->setHeader('X-Priority', '3');
        $email_service->setHeader('X-Mailer', 'PHP/' . phpversion());
        $email_service->setMessage($messageHtml);

        $message_text = strip_tags(str_replace(['<br>', '<li>', '</ul>', '</p>'], ["\n", "- ", "\n", "\n\n"], $messageHtml));
        $email_service->setAltMessage($message_text);

        return $email_service->send();
    }
}
