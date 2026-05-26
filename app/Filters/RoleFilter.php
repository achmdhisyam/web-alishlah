<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments [0] could be allowed roles string, comma separated. e.g. "Admin,User,spmb"
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        
        // Cek login
        if (!$session->get('username')) {
            $session->setFlashdata('warning', 'Anda belum login.');
            return redirect()->to(base_url('login'));
        }

        // Cek role arguments
        if ($arguments) {
            // Role saat ini
            $current_role = $session->get('akses_level');

            // Cek apakah role saat ini ada dalam allowed roles
            if (!in_array($current_role, $arguments)) {
                $session->setFlashdata('warning', 'Akses ditolak. Anda tidak memiliki izin (role: ' . $current_role . ') untuk halaman ini.');
                return redirect()->to(base_url('admin/dasbor'));
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
