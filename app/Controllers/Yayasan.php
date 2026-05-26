<?php
namespace App\Controllers;
use App\Models\Konfigurasi_model;
use App\Models\Yayasan_model;
use App\Models\Nav_model;

class Yayasan extends BaseController
{
    // index
    public function index()
    {
        $pager          = service('pager'); 
        $m_site         = new Konfigurasi_model();
        $site           = $m_site->listing();
        $m_yayasan      = new Yayasan_model();
        $status_yayasan = 'Publish';
        $total          = $m_yayasan->total_status_yayasan($status_yayasan);
        $page           = (int) ($this->request->getGet('page') ?? 1);
        $perPage        = $this->website->paginasi_depan();
        $pager_links    = $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page           = ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $yayasan        = $m_yayasan->status_yayasan_all($status_yayasan,$perPage, $page);

        $data = [   'title'         => 'Informasi Yayasan',
                    'description'   => 'Informasi Lengkap Yayasan',
                    'keywords'      => 'Yayasan, Informasi',
                    'site'          => $site,
                    'yayasan'       => $yayasan,
                    'pagination'    => $pager_links,
                    'content'       => 'yayasan/index'
                ];
        return view('layout/wrapper',$data);
    }

    // read
    public function read($slug_yayasan)
    {
        $m_yayasan      = new Yayasan_model();
        $yayasan        = $m_yayasan->read($slug_yayasan);
        $news           = $m_yayasan->beranda(10);

        $data = array(  'id_yayasan' => $yayasan->id_yayasan,
                        'hits'       => $yayasan->hits+1
                    );
        $m_yayasan->edit($data);

        $data = [   'title'         => $yayasan->judul_yayasan,
                    'description'   => $yayasan->ringkasan,
                    'keywords'      => $yayasan->judul_yayasan.', '.$yayasan->keywords,
                    'yayasan'       => $yayasan,
                    'news'          => $news,
                    'content'       => 'yayasan/read'
                ];
        return view('layout/wrapper',$data);
    }
}
