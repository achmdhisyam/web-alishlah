<?php
namespace App\Controllers;
use App\Models\Konfigurasi_model;
use App\Models\Berita_model;
use App\Models\Menu_model;
use App\Models\Kategori_model;
use App\Models\Profil_model;
use App\Models\Visi_misi_model;
use App\Models\Sambutan_model;

class Profil extends BaseController
{
    // index
    public function index()
    {
        $pager          = service('pager'); 
        $m_site         = new Konfigurasi_model();
        $site           = $m_site->listing();
        $m_berita       = new Berita_model();
        $status_berita  = 'Publish';
        $jenis_berita   = 'Berita';
        $total          = $m_berita->total_jenis_status_berita($jenis_berita,$status_berita);
        $page           = (int) ($this->request->getGet('page') ?? 1);
        $perPage        = $this->website->paginasi_depan();
        $total          = $total;
        $pager_links    = $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page           = ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $berita         = $m_berita->jenis_status_berita_all($jenis_berita,$status_berita,$perPage, $page);

        $data = [   'title'         => 'Tentang Kami',
                    'description'   => 'Tentang Kami - '.$this->website->namaweb(),
                    'keywords'      => 'Berita Terbaru - '.$this->website->namaweb(),
                    'site'          => $site,
                    'berita'        => $berita,
                    'pagination'    => $pager_links,
                    'content'       => 'berita/index'
                ];
        return view('layout/wrapper',$data);
    }

    // kategori
    public function kategori($slug_kategori)
    {
        $pager          = service('pager'); 
        $m_site         = new Konfigurasi_model();
        $site           = $m_site->listing();
        $m_berita       = new Berita_model();
        $m_kategori     = new Kategori_model();
        $kategori       = $m_kategori->read($slug_kategori);
        $id_kategori    = $kategori->id_kategori;
        $status_berita  = 'Publish';
        $jenis_berita   = 'Berita';
        $total          = $m_berita->total_kategori_status_jenis($id_kategori,$jenis_berita,$status_berita,);
        $page           = (int) ($this->request->getGet('page') ?? 1);
        $perPage        = $this->website->paginasi_depan();
        $total          = $total;
        $pager_links    = $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page           = ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $berita         = $m_berita->kategori_status_jenis_all($id_kategori,$jenis_berita,$status_berita,$perPage, $page);
        

        $data = [   'title'         => $kategori->nama_kategori,
                    'description'   => $kategori->nama_kategori,
                    'keywords'      => $kategori->nama_kategori,
                    'site'          => $site,
                    'berita'        => $berita,
                    'pagination'    => $pager_links,
                    'content'       => 'berita/index'
                ];
        return view('layout/wrapper',$data);
    }

    // read
    public function read($slug_berita)
    {
        $m_berita   = new Berita_model();
        $berita     = $m_berita->read($slug_berita);
        $news       = $m_berita->sidebar();

        $data = array(  'id_berita' => $berita->id_berita,
                        'hits'      => $berita->hits+1
                    );
        $m_berita->edit($data);

        $data = [   'title'         => $berita->judul_berita,
                    'description'   => $berita->ringkasan,
                    'keywords'      => $berita->judul_berita.', '.$berita->keywords,
                    'berita'        => $berita,
                    'news'          => $news,
                    'content'       => 'berita/read'
                ];
        return view('layout/wrapper',$data);
    }

    // profil
    public function profil($slug_berita)
    {
        $m_berita   = new Berita_model();
        $m_menu     = new Menu_model();
        $berita     = $m_berita->read($slug_berita);
        $news       = $m_menu->profil('Profil');

        $data = array(  'id_berita' => $berita->id_berita,
                        'hits'      => $berita->hits+1
                    );
        $m_berita->edit($data);

        $data = [   'title'         => $berita->judul_berita,
                    'description'   => $berita->ringkasan,
                    'keywords'      => $berita->judul_berita.', '.$berita->keywords,
                    'berita'        => $berita,
                    'news'          => $news,
                    'content'       => 'berita/profil'
                ];
        return view('layout/wrapper',$data);
    }

    // layanan
    public function layanan($slug_berita)
    {
        $m_berita   = new Berita_model();
        $m_menu     = new Menu_model();
        $berita     = $m_berita->read($slug_berita);
        $news       = $m_menu->profil('Layanan');

        $data = array(  'id_berita' => $berita->id_berita,
                        'hits'      => $berita->hits+1
                    );
        $m_berita->edit($data);

        $data = [   'title'         => $berita->judul_berita,
                    'description'   => $berita->ringkasan,
                    'keywords'      => $berita->judul_berita.', '.$berita->keywords,
                    'berita'        => $berita,
                    'news'          => $news,
                    'content'       => 'berita/profil'
                ];
        return view('layout/wrapper',$data);
    }

    // sejarah
    public function sejarah()
    {
        $db = \Config\Database::connect();
        $profil = $db->table('profil')->where('status_profil', 'Publish')->orderBy('id_profil', 'DESC')->get()->getRow();
        if(!$profil) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // Increment hits
        $db->table('profil')->where('id_profil', $profil->id_profil)->update(['hits' => $profil->hits + 1]);

        $data = [   'title'         => $profil->judul_profil,
                    'description'   => $profil->ringkasan,
                    'keywords'      => $profil->keywords,
                    'profil'        => $profil,
                    'content'       => 'profil/sejarah'
                ];
        return view('layout/wrapper',$data);
    }

    // visi_misi
    public function visi_misi()
    {
        $db = \Config\Database::connect();
        $visi_misi = $db->table('visi_misi')->where('status_visi_misi', 'Publish')->orderBy('id_visi_misi', 'DESC')->get()->getRow();
        if(!$visi_misi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // Increment hits
        $db->table('visi_misi')->where('id_visi_misi', $visi_misi->id_visi_misi)->update(['hits' => $visi_misi->hits + 1]);

        $data = [   'title'         => $visi_misi->judul_visi_misi,
                    'description'   => $visi_misi->ringkasan,
                    'keywords'      => $visi_misi->keywords,
                    'visi_misi'     => $visi_misi,
                    'content'       => 'profil/visi_misi'
                ];
        return view('layout/wrapper',$data);
    }

    // sambutan
    public function sambutan()
    {
        $db = \Config\Database::connect();
        $sambutan = $db->table('sambutan')->where('status_sambutan', 'Publish')->orderBy('id_sambutan', 'DESC')->get()->getRow();
        if(!$sambutan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // Increment hits
        $db->table('sambutan')->where('id_sambutan', $sambutan->id_sambutan)->update(['hits' => $sambutan->hits + 1]);

        $data = [   'title'         => $sambutan->judul_sambutan,
                    'description'   => $sambutan->ringkasan,
                    'keywords'      => $sambutan->keywords,
                    'sambutan'      => $sambutan,
                    'content'       => 'profil/sambutan'
                ];
        return view('layout/wrapper',$data);
    }

}
