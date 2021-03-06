<?php
class Absensi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Mabsensi');
        if (!$this->session->userdata('user'))
        {
            $log = base_url("mastercms");
            $this->session->set_flashdata('msg', '<div class="alert alert-block alert-info fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><i class="fa fa-warning"></i>&nbsp;&nbsp;Anda harus login terlebih dahulu.</div>');
            echo "<script>location='$log';</script>";
        }
    }
    public function index(){
        $data['absensi']    = "";
        $data['lokasi']     = "";
        $data['bulan']     = "";
        $data['data']       = $this->Mabsensi->get_cabang();
        $this->render_page('backend/report/absensi',$data);
    }

    public function get_karyawan(){
        $id     = $this->input->post('id');
        $data   = $this->Mabsensi->get_karyawan($id);
        echo json_encode($data);
    }

    public function pencarian(){
        $cabang     = $this->input->get('cabang');
        $bulan      = $this->input->get('filterbulan');
        $tahun      = $this->input->get('tahun');
        $karyawan   = $this->input->get('karyawan');
        $data['lokasi'] = $cabang;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['karyawan'] = $karyawan;
        $data['data']=$this->Mabsensi->get_cabang();
        $data['absensi']=$this->Mabsensi->pencarian_d($cabang,$bulan,$tahun,$karyawan);

        switch ($bulan) {
            case '01':
               $data['month'] = "Januari";
                break;
            case '02':
                $data['month'] = "Februari";
                break;
            case '03':
                $data['month'] = "Maret";
                break;
            case '04':
                $data['month'] = "April";
                break;
            case '05':
                $data['month'] = "Mei";
                break;
            case '06':
                $data['month'] = "Juni";
                break;
            case '07':
                $data['month'] = "Juli";
                break;
            case '08':
                $data['month'] = "Agustus";
                break;
            case '09':
                $data['month'] = "September";
                break;
            case '10':
                $data['month'] = "Oktober";
                break;
            case '11':
                $data['month'] = "November";
                break;
            case '12':
                $data['month'] = "Desember";
                break;
            default:
                break;
        }

        $this->render_page('backend/report/absensi',$data);
        // $this->render_page('backend/report/filter_absensi',$data);
    }
    public function summary()
    {
        $id = $_SESSION['user']['perusahaan_id'];
        $data['cabang'] = $this->Mabsensi->semua_cabang($id);
        if ($this->input->post()) { //Perintah yg dijalankan saat user mengklik lokasi perusahaan yg dipilih
            $input = $this->input->post();
            $lokasi_id = $input['lokasi_id'];
            $bulan = date('m');
            $tahun = date('Y');

            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['karyawan'] = $this->Mabsensi->semua_karyawan($lokasi_id);
            $data['lokasi_id'] = $lokasi_id;
            $data['lokasi'] = $this->Mabsensi->lokasi_by_id($lokasi_id);
            $data['jml_hari_kerja'] = $this->Mabsensi->jml_hari_kerja($lokasi_id, $bulan, $tahun);
            $data['presensi'] = $this->Mabsensi->presensi_per_karyawan($bulan, $tahun);
            $data['kehadiran'] = $this->Mabsensi->kehadiran($bulan, $tahun);
        }
        elseif ($this->input->get()) //Perintah yg dijalankan saat tombol cari diklik (methode formnya "GET")
        { 
            $input = $this->input->get();
            $lokasi_id = $input['lokasi_id'];
            if (!empty($this->input->get('cari'))) 
            {
                $bulan = $input['bulan'];
                $tahun = $input['tahun'];
            }
            elseif (!empty($this->input->get('reset'))) 
            {
                $bulan = date('m');
                $tahun = date('Y');
            }
            else
            {
                echo "Pencarian tidak diketahui";
            }
            
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['lokasi_id'] = $lokasi_id;
            $data['lokasi'] = $this->Mabsensi->lokasi_by_id($lokasi_id);
            $data['karyawan'] = $this->Mabsensi->semua_karyawan($lokasi_id);
            $data['jml_hari_kerja'] = $this->Mabsensi->jml_hari_kerja($lokasi_id, $bulan, $tahun);
            $data['presensi'] = $this->Mabsensi->presensi_per_karyawan($bulan, $tahun);
            $data['kehadiran'] = $this->Mabsensi->kehadiran($bulan, $tahun);
        }
        else //Perintah yg dijalankan pada saat user belum mengklik lokasi perusahaan
        { 
            $lokasi_id = "";
            $data['lokasi'] = "";
            $bulan = date('m');
            $tahun = date('Y');

            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['karyawan'] = $this->Mabsensi->semua_karyawan($lokasi_id);
            $data['kehadiran'] = $this->Mabsensi->kehadiran($bulan,$tahun);
        }
        
        $this->render_page('backend/report/summary', $data);
    }

    public function export_excel($lokasi_id, $bulan, $tahun){
            $data = array( 'title' => 'Laporan Excel | Absensi',
                'karyawan' => $this->Mabsensi->semua_karyawan($lokasi_id),
                'kehadiran' => $this->Mabsensi->kehadiran($bulan, $tahun),
                'lokasi_by_id' => $this->Mabsensi->lokasi_by_id($lokasi_id),
                'jml_hari_kerja' => $this->Mabsensi->jml_hari_kerja($lokasi_id, $bulan, $tahun),
                'presensi' => $this->Mabsensi->presensi_per_karyawan($bulan, $tahun),
                'bulan' => $bulan,
                'tahun' => $tahun);
           $this->load->view('backend/report/excel_semua_karyawan',$data);
    }
    public function detail($karyawan_id, $bulan){
        $data['detail_data'] = $this->Mabsensi->detail($karyawan_id);
        $data['detail_data_absensi'] = $this->Mabsensi->detail_absensi($karyawan_id, $bulan);
        $data['bulan'] = $bulan;

        $this->render_page('backend/report/detail', $data);
    }

    function export_excel_karyawan($lokasi,$bulan,$tahun,$karyawan){
        $nama = str_replace("%20", " ", $karyawan); 
        $data = array( 'title' => $karyawan.' - Laporan Presensi Karyawan',
            'lokasi_by_id' => $this->Mabsensi->lokasi_by_id($lokasi),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'user' => $this->Mabsensi->absensi_perorangan($lokasi,$bulan,$tahun,$nama));
       $this->load->view('backend/report/excel_karyawan',$data);
    }

    // function emailSend(){
    //     $fromEmail = "hilo73ch@gmail.com";
    //     $isiEmail = "Isi email tulis disini";
    //     $mail = new PHPMailer();
    //     $mail->IsHTML(true);    // set email format to HTML
    //     $mail->IsSMTP();   // we are going to use SMTP
    //     $mail->SMTPAuth   = true; // enabled SMTP authentication
    //     $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
    //     $mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
    //     $mail->Port       = 465;                   // SMTP port to connect to GMail
    //     $mail->Username   = $fromEmail;  // alamat email kamu
    //     $mail->Password   = "sismart16";            // password GMail
    //     $mail->SetFrom('info@yourdomain.com', 'noreply');  //Siapa yg mengirim email
    //     $mail->Subject    = "Subjek email";
    //     $mail->Body       = $isiEmail;
    //     $toEmail = "enieyuliani.99@gmail.com"; // siapa yg menerima email ini
    //     $mail->AddAddress($toEmail);
       
    //     if(!$mail->Send()) {
    //         echo "Eror: ".$mail->ErrorInfo;
    //     } else {
    //         echo "Email berhasil dikirim";
    //     }
    // }

}
?>