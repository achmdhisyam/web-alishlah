<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Download_model;

class Dasbor extends BaseController
{
	public function index()
	{
		
		$data = [   'title'     => 'Dasbor Administrator',
					'content'	=> 'admin/dasbor/index'
                ];
        return view('admin/layout/wrapper',$data);
	}

	public function panduan()
	{
		$m_download 	= new Download_model();
		$download 		= $m_download->jenis_download('Panduan');

		$data = [   'title'     => 'Manual dan User Guide',
					'download'	=> $download,
					'content'	=> 'admin/dasbor/panduan'
                ];
        return view('admin/layout/wrapper',$data);
	}
}