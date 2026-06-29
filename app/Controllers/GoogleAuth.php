<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Konfigurasi_model;
use App\Models\Akun_model;
use App\Models\User_model;

class GoogleAuth extends BaseController
{
    private $konfigurasi;

    public function __construct()
    {
        $m_konfigurasi = new Konfigurasi_model();
        $this->konfigurasi = $m_konfigurasi->listing();
    }

    public function login($role = 'siswa')
    {
        if(empty($this->konfigurasi->google_client_id)) {
            return redirect()->back()->with('warning', 'Google Login belum dikonfigurasi oleh Admin.');
        }

        $this->session->set('google_auth_role', $role);

        $params = [
            'client_id'     => $this->konfigurasi->google_client_id,
            'redirect_uri'  => base_url('googleauth/callback'),
            'response_type' => 'code',
            'scope'         => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
            'access_type'   => 'offline',
            'prompt'        => 'select_account'
        ];

        $authUrl = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query($params);
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $code = $this->request->getVar('code');
        if (empty($code)) {
            return redirect()->to(base_url())->with('warning', 'Gagal login melalui Google.');
        }

        // 1. Tukar Code dengan Access Token
        $client = \Config\Services::curlrequest();
        $response = $client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'code'          => $code,
                'client_id'     => $this->konfigurasi->google_client_id,
                'client_secret' => $this->konfigurasi->google_client_secret,
                'redirect_uri'  => base_url('googleauth/callback'),
                'grant_type'    => 'authorization_code',
            ],
        ]);

        $tokenData = json_decode($response->getBody(), true);
        if (isset($tokenData['access_token'])) {
            $accessToken = $tokenData['access_token'];

            // 2. Ambil data profil user
            $profileResponse = $client->get('https://www.googleapis.com/oauth2/v2/userinfo', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            $userData = json_decode($profileResponse->getBody(), true);
            $email = $userData['email'];
            $name  = $userData['name'];
            $role  = $this->session->get('google_auth_role');

            if ($role == 'admin') {
                return $this->processAdmin($email, $name);
            } else {
                return $this->processSiswa($email, $name);
            }
        }

        return redirect()->to(base_url())->with('warning', 'Gagal memverifikasi akun Google.');
    }

    private function processAdmin($email, $name)
    {
        $m_user = new User_model();
        $user = $m_user->check($email);

        if ($user) {
            $this->session->set([
                'username'    => $user->username,
                'nama'        => $user->nama,
                'akses_level' => $user->akses_level,
                'id_user'     => $user->id_user,
            ]);
            return redirect()->to(base_url('admin/dasbor'))->with('sukses', 'Berhasil login melalui Google.');
        } else {
            return redirect()->to(base_url('login'))->with('warning', 'Email Google Anda belum didaftarkan sebagai Admin.');
        }
    }

    private function processSiswa($email, $name)
    {
        $m_akun = new Akun_model();
        $akun = $m_akun->email($email);

        if ($akun) {
            $this->session->set([
                'username_siswa' => $akun->email,
                'nama'           => $akun->nama,
                'email'          => $akun->email,
                'id_akun'        => $akun->id_akun,
                'nis'            => $akun->nis,
            ]);
            return redirect()->to(base_url('siswa/dasbor'))->with('sukses', 'Berhasil login melalui Google.');
        } else {
            // Seamless registration
            $data = [
                'nama'         => $name,
                'email'        => $email,
                'username'     => $email,
                'password'     => password_hash(bin2hex(random_bytes(4)), PASSWORD_DEFAULT),
                'status_akun'  => 'Aktif',
                'kode_akun'    => bin2hex(random_bytes(16)),
                'tanggal_post' => date('Y-m-d H:i:s'),
            ];
            $m_akun->tambah($data);
            $akunBaru = $m_akun->email($email);

            // Kirim Email Selamat Datang
            $this->sendWelcomeEmail($email, $name);

            $this->session->set([
                'username_siswa' => $akunBaru->email,
                'nama'           => $akunBaru->nama,
                'email'          => $akunBaru->email,
                'id_akun'        => $akunBaru->id_akun,
            ]);
            return redirect()->to(base_url('siswa/dasbor'))->with('sukses', 'Pendaftaran akun via Google Berhasil!. Silakan memilih periode pendaftaran dan lanjutkan mengisi biodata. Email Informasi akun telah dikirim ke alamat Gmail Anda.');
        }
    }

    private function sendWelcomeEmail($email, $nama)
    {
        $email_config = [
            'protocol'   => $this->konfigurasi->protocol,
            'SMTPHost'   => $this->konfigurasi->smtp_host,
            'SMTPUser'   => $this->konfigurasi->smtp_user,
            'SMTPPass'   => $this->konfigurasi->smtp_pass,
            'SMTPPort'   => (int) $this->konfigurasi->smtp_port,
            'SMTPTimeout'=> (int) $this->konfigurasi->smtp_timeout,
            'SMTPCrypto' => $this->konfigurasi->smtp_crypto,
            'mailType'   => 'html',
            'charset'    => 'utf-8',
            'newline'    => "\r\n",
            'CRLF'       => "\r\n"
        ];

        $dataEmail = [
            'nama'       => $nama,
            'email'      => $email,
            'link_login' => base_url('signin'),
            'namaweb'    => $this->konfigurasi->namaweb
        ];

        $message_html = view('email_templates/pendaftaran_akun', $dataEmail);
        $message_text = strip_tags(str_replace(['<br>', '<li>', '</ul>', '</p>'], ["\n", "- ", "\n", "\n\n"], $message_html));

        $email_service = \Config\Services::email();
        $email_service->initialize($email_config);
        $email_service->setFrom($this->konfigurasi->smtp_user, $this->konfigurasi->namaweb);
        $email_service->setReplyTo($this->konfigurasi->smtp_user, $this->konfigurasi->namaweb);
        $email_service->setTo($email);
        $email_service->setSubject('Pendaftaran Akun Berhasil - ' . $this->konfigurasi->namaweb);

        // Extra headers to avoid spam
        $email_service->setHeader('Organization', $this->konfigurasi->namaweb);
        $email_service->setHeader('X-Priority', '3'); // 3 = Normal
        $email_service->setHeader('X-Mailer', 'PHP/' . phpversion());

        $email_service->setMessage($message_html);
        $email_service->setAltMessage($message_text);

        return $email_service->send();
    }
}
