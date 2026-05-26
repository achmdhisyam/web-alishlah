<?php

namespace App\Controllers;
use App\Models\User_model;
use App\Models\Konfigurasi_model;

class Login extends BaseController
{
    // login
    public function index()
    {
        // Start validasi
        if($this->request->getMethod() === 'POST' && $this->validate(
            [
            'username'  => 'required|min_length[3]',
            'password'  => 'required|min_length[3]',
            ])) 
        {           
            $username       = $this->request->getPost('username');
            $password       = $this->request->getPost('password');
            $pengalihan     = $this->request->getPost('pengalihan');
            $this->simple_login->login($username,$password,$pengalihan);
        }
        $m_site     = new Konfigurasi_model();
        $site       = $m_site->listing();
        
        $data = [   'title'     => 'Login Administrator',
                    'site'      => $site,
                    'content'   => 'login/index'
                ];
        return view('login/wrapper',$data);
    }

    // coba
    public function coba()
    {
        $username       = 'andoyo';
        $password       = 'andoyo';
        $pengalihan     = '';
        $this->simple_login->login($username,$password,$pengalihan);
    }

    // lupa
    public function lupa()
    {
        $m_site         = new Konfigurasi_model();
        $m_user         = new User_model();
        $site           = $m_site->listing();
        
        // Start validasi
        if($this->request->getMethod() === 'POST' && $this->validate(
            [
            'email'  => 'required|min_length[3]',
            ])) 
        {           
            $email  = $this->request->getPost('email');
            $check  = $m_user->check($email);
            if($check) {
                $data = [   'id_user'       => $check->id_user,
                            'kode_rahasia'  => random_string('alnum',64),
                            // [PERBAIKAN KEAMANAN] Menggunakan getIPAddress bawaan CI4 agar lebih aman dari IP spoofing
                            'ip_address'    => $this->request->getIPAddress()
                    ];
                $m_user->edit($data);
                $hasil              = $m_user->check($email);

                // Link reset password
                $link_reset = base_url('login/reset/' . $hasil->kode_rahasia);
                
                $subject = 'Permintaan Reset Password - ' . $this->website->namaweb();

                $dataEmail = [
                    'nama' => $check->nama,
                    'link_reset' => $link_reset,
                    'namaweb' => $site->namaweb
                ];
                $message_html = view('email_templates/lupa_password', $dataEmail);

                if ($this->sendEmail($email, $subject, $message_html)) {
                    return redirect()->to(base_url('login/lupa'))->with('sukses', 'Link reset password telah dikirimkan email. Silakan check folder spam email jika email tidak ditemukan.');
                } else {
                    return redirect()->to(base_url('login/lupa'))->with('warning', 'Pengiriman email gagal. Silakan hubungi administrator.');
                } 
            }else{
                return redirect()->to(base_url('login/lupa'))->with('warning', 'Mohon Maaf. Email tidak ditemukan atau tidak terdaftar.');
            }
            
        }
        // end validasi
        
        $data = [   'title'     => 'Lupa Password',
                    'site'      => $site,
                    'content'   => 'login/lupa'
                ];
        return view('login/wrapper',$data);
    }

    // reset
    public function reset($kode_rahasia='')
    {
        $m_site         = new Konfigurasi_model();
        $m_user         = new User_model();
        $site           = $m_site->listing();
        $user           = $m_user->kode_rahasia($kode_rahasia);

        if($kode_rahasia == '')//! validate empty token
        {
            $this->session->setFlashdata('warning','Token invalid atau Masa berlaku token sudah habis');
            return redirect()->to(base_url('login'));
        }

        if($user == null)
        {
            $this->session->setFlashdata('warning','Token invalid atau Masa berlaku token sudah habis');
            return redirect()->to(base_url('login'));
        }
        // Start validasi
        if($this->request->getMethod() === 'POST' && $this->validate([
            'password'                  => 'required|min_length[6]',
            'password_konfirmasi'       => 'required|matches[password]'
        ])) {
            
            $data = [   'id_user'       => $user->id_user,
                        'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                        // 'password'      => sha1($this->request->getPost('password')),
                        'kode_rahasia'  => ''
                    ];
            $m_user->edit($data);
            // masuk database
            $this->session->setFlashdata('sukses','Password telah diupdate');
            return redirect()->to(base_url('login'));
        }else{

            $data = [   'title'         => 'Reset Password',
                        'site'          => $site,
                        'user'          => $user,
                        'kode_rahasia'  => $kode_rahasia,
                        'content'       => 'login/reset'
                    ];
            return view('login/wrapper',$data);
        }
    }

    // logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('login?logout=sukses'));
    }
}
