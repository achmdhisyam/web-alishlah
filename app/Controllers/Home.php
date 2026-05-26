<?php

namespace App\Controllers;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Konfigurasi_model;
use App\Models\Galeri_model;
use App\Models\Slider_model;
use App\Models\Popup_model;
use App\Models\Berita_model;
use App\Models\Staff_model;
use App\Models\Prestasi_model;
use App\Models\Video_model;
use App\Models\Client_model;
use App\Models\Program_pendidikan_model;
use App\Models\Yayasan_model;
use App\Models\Keunggulan_model;

class Home extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->konfigurasi_model    = new Konfigurasi_model();
        $this->galeri_model         = new Galeri_model();
        $this->slider_model         = new Slider_model();
        $this->popup_model          = new Popup_model();
        $this->berita_model         = new Berita_model();
        $this->staff_model          = new Staff_model();
        $this->prestasi_model       = new Prestasi_model();
        $this->video_model          = new Video_model();
        $this->client_model         = new Client_model();
        $this->program_pendidikan_model   = new Program_pendidikan_model();
        $this->yayasan_model        = new Yayasan_model();
        $this->keunggulan_model     = new Keunggulan_model();
    }

    // index
    public function index()
    {
        $site       = $this->konfigurasi_model->listing();
        $galeri     = $this->slider_model->listing();
        $popup      = $this->popup_model->popup_active();
        $keunggulan = $this->keunggulan_model->main();
        $berita     = $this->berita_model->beranda('Berita',6);
        $staff      = $this->staff_model->home(6);
        $prestasi   = $this->prestasi_model->home(6,'Publish');
        $video      = $this->video_model->home();
        $video_list = $this->video_model->semua(6,0); // Ambil 6 video terbaru
        $galeri_foto = $this->galeri_model->jenis_galeri_list('Galeri'); // Ambil galeri jenis 'Galeri'
        $client     = $this->client_model->home();
        $program_pendidikan     = $this->program_pendidikan_model->main();
        $yayasan    = $this->yayasan_model->main();

        $data = [   'title'         => $site->namaweb.' | '.$site->tagline,
                    'description'   => $site->deskripsi,
                    'keywords'      => $site->keywords,
                    'site'          => $site,
                    'slider'        => $galeri,
                    'popup'         => $popup,
                    'keunggulan'    => $keunggulan,
                    'berita'        => $berita,
                    'staff'         => $staff,
                    'prestasi'      => $prestasi,
                    'video'         => $video,
                    'video_list'    => $video_list,
                    'galeri_foto'   => $galeri_foto,
                    'client'        => $client,
                    'program_pendidikan'    => $program_pendidikan,
                    'yayasan'       => $yayasan,
                    'content'       => 'home/index'
                ];
        return view('layout/wrapper',$data);
    }

    // oops
    public function oops()
    {
        $m_site     = new Konfigurasi_model();
        $site       = $m_site->listing();
        $data = [   'title'         => 'Oops... Mohon Maaf',
                    'description'   => 'Oops... Mohon Maaf',
                    'keywords'      => 'Oops... Mohon Maaf',
                    'site'          => $site,
                    'content'       => 'home/oops'
                ];
        return view('layout/wrapper',$data);
    }

    // welcome
    public function welcome()
    {
        return view('welcome_message');
    }

}
