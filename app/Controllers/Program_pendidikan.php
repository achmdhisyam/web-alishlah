<?php
namespace App\Controllers;
use App\Models\Konfigurasi_model;
use App\Models\Program_pendidikan_model;
use App\Models\Nav_model;

// [REFACTORING] File dan seluruh fungsi telah diubah dari Jenjang_pendidikan menjadi Program_pendidikan
class Program_pendidikan extends BaseController
{
    // index
    public function index()
    {
        $pager          = service('pager'); 
        $m_site         = new Konfigurasi_model();
        $site           = $m_site->listing();
        $m_program_pendidikan       = new Program_pendidikan_model();
        $status_program_pendidikan  = 'Publish';
        $jenis_program_pendidikan   = 'Program Pendidikan';
        $total          = $m_program_pendidikan->total_jenis_status_program_pendidikan($jenis_program_pendidikan,$status_program_pendidikan);
        $page           = (int) ($this->request->getGet('page') ?? 1);
        $perPage        = $this->website->paginasi_depan();
        $total          = $total;
        $pager_links    = $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page           = ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $program_pendidikan         = $m_program_pendidikan->jenis_status_program_pendidikan_all($jenis_program_pendidikan,$status_program_pendidikan,$perPage, $page);

        $data = [   'title'         => 'Program Pendidikan',
                    'description'   => 'Program Unggulan',
                    'keywords'      => 'Program Unggulan',
                    'site'          => $site,
                    'program_pendidikan'        => $program_pendidikan,
                    'pagination'    => $pager_links,
                    'content'       => 'program_pendidikan/index'
                ];
        return view('layout/wrapper',$data);
    }

    // read
    public function read($slug_program_pendidikan)
    {
        $m_program_pendidikan   = new Program_pendidikan_model();
        $program_pendidikan     = $m_program_pendidikan->read($slug_program_pendidikan);
        $news                   = $m_program_pendidikan->sidebar();
        // print_r($program_pendidikan);
        $data = array(  'id_program_pendidikan' => $program_pendidikan->id_program_pendidikan,
                        'hits'                  => $program_pendidikan->hits+1
                    );
        $m_program_pendidikan->edit($data);
        

        $data = [   'title'                 => $program_pendidikan->judul_program_pendidikan,
                    'description'           => $program_pendidikan->ringkasan,
                    'keywords'              => $program_pendidikan->judul_program_pendidikan.', '.$program_pendidikan->keywords,
                    'program_pendidikan'    => $program_pendidikan,
                    'news'                  => $news,
                    'content'               => 'program_pendidikan/read'
                ];
        return view('layout/wrapper',$data);
    }

    // profil
    public function profil($id_program_pendidikan)
    {
        $m_program_pendidikan   = new Program_pendidikan_model();
        $m_nav      = new Nav_model();
        $program_pendidikan     = $m_program_pendidikan->read($id_program_pendidikan);
        $news       = $m_nav->profil('Profil');

        $data = array(  'id_program_pendidikan' => $program_pendidikan->id_program_pendidikan,
                        'hits'      => $program_pendidikan->hits+1
                    );
        $m_program_pendidikan->edit($data);

        $data = [   'title'         => $program_pendidikan->judul_program_pendidikan,
                    'description'   => $program_pendidikan->ringkasan,
                    'keywords'      => $program_pendidikan->judul_program_pendidikan.', '.$program_pendidikan->keywords,
                    'program_pendidikan'        => $program_pendidikan,
                    'news'          => $news,
                    'content'       => 'program_pendidikan/profil'
                ];
        return view('layout/wrapper',$data);
    }

    // layanan
    public function layanan($id_program_pendidikan)
    {
        $m_program_pendidikan   = new Program_pendidikan_model();
        $m_menu     = new Menu_model();
        $program_pendidikan     = $m_program_pendidikan->read($id_program_pendidikan);
        $news       = $m_menu->profil('Layanan');

        $data = array(  'id_program_pendidikan' => $program_pendidikan->id_program_pendidikan,
                        'hits'      => $program_pendidikan->hits+1
                    );
        $m_program_pendidikan->edit($data);

        $data = [   'title'         => $program_pendidikan->judul_program_pendidikan,
                    'description'   => $program_pendidikan->ringkasan,
                    'keywords'      => $program_pendidikan->judul_program_pendidikan.', '.$program_pendidikan->keywords,
                    'program_pendidikan'        => $program_pendidikan,
                    'news'          => $news,
                    'content'       => 'program_pendidikan/profil'
                ];
        return view('layout/wrapper',$data);
    }

}
