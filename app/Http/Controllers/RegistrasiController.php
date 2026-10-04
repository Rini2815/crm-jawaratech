namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index()
    {
        // Sesuaikan nama file view blade kamu di sini (misal: views/registrasi/index.blade.php)
        return view('registrasi.index');
    }
}