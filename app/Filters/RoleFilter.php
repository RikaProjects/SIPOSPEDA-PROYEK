<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        // Jika belum login
        if (! $session->has('role')) {
            return redirect()->to('/login');
        }

        // Jika ada batasan role
        if ($arguments) {
            $userRole = $session->get('role');

            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/unauthorized'); // Buat halaman unauthorized jika perlu
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu isi
    }
}
