<?php

namespace App\Http\Controllers;
use App\Models\Cluster;
use Phpml\Clustering\KMeans; //untuk cluster
//untuk menggunakan knn sbg mesin learningnya
use Illuminate\Http\Request;

class ClusterController extends Controller
{

    public function coba(){
        echo "hello world";
    }

    //fungsi mencoba algoritma cluster
    public function cobacluster(){
		
		$samples = [[1, 1], [8, 7], [1, 2], [7, 8], [2, 1], [8, 9]];
        // dicluster sebanyak 2 cluster
		$kmeans = new KMeans(2, KMeans::INIT_RANDOM);
		$data['Samples'] = $samples;
		$data['Cluster'] = $kmeans->cluster($samples);

		echo "<pre>";
        var_dump($data['Samples']);  echo "<hr>";
        var_dump($data['Cluster']);  echo "<hr>";
		echo "</pre>";
	}
	
	
    //fungsi untuk cluster biaya tani
    // public function clusterbiaya2($periodeawal,$periodeakhir){
    //     $data = ['periodeawal'=>$periodeawal,'periodeakhir'=>$periodeakhir];
    //     return view('cluster/clusterbiaya',$data);
    // }
    
    public function clusterbiaya(Request $request){
        // contoh samples
        // $samples = [[1, 1], [8, 7], [1, 2], [7, 8], [2, 1], [8, 9]];
        if ($request->has('submit')) {
            if(isset($_GET['start_date'])){
                $start_date = $_GET['start_date'];
            }else{
                $start_date = '2023-01-01';
            }
            
            if(isset($_GET['end_date'])){
                $end_date = $_GET['end_date'];
            }else{
                $end_date = date('Y').'-12-31';
            }
            
            $k = $_GET['jml_cluster'];
    	    //$start_date = $_GET['start_date'];
    	    //$end_date = $_GET['end_date'];
    	    //$start_date = $_GET['start_date'];
    	    //$end_date = $_GET['end_date'];
    	    //echo $start_date;
        }else{
            $k = 3;
    	    $start_date = '2023-01-01';
    	    $end_date = date('Y').'-12-31';
        }
        
        $hsl = Cluster::getClusterBiaya($start_date,$end_date);
        // dd($hsl);
        // cacah dan clusterkan di sini
        $features = [];
        $identitas = [];
        $dtXYZ = array();
        $ttl = [];
        foreach ($hsl as $h) {
            $isi = [];
            $isi[] = floatval($h->rc);
            $identitas[] = $h->kode_tanam.'-'.$h->nama_komoditas.'-'.$h->kode_lahan;
            $features[] = $isi;
            $z = floatval($h->beban_variabel) + floatval($h->beban_fix);
            $dtXYZ[] = array(floatval($h->keuntungan),floatval($z),floatval($h->rc));
            $total = (floatval($h->keuntungan)+floatval($z));
            $ttl[] = $total/3;
        }
        $samples = $features;

        
        $kmeans = new KMeans($k);
		$data['Samples'] = $samples;
		$data['Cluster'] = $kmeans->cluster($samples);
		// Mendapatkan indeks data dari hasil clustering
		$clusterAssignments = [];

		$clusterAssignments = array();
		foreach ($data['Cluster'] as $clusterIndex => $cluster) {
			$kelompok = array_keys($cluster);
			$clusterAssignments[] = $kelompok;
		}
		
		$zw = 0;
		$idx_data = [];
		$idx_cluster = [];
		foreach($clusterAssignments as $z){
			// echo "<pre>";
			for($i=0;$i<count($z);$i++){
				// 6=++0 berarti $z adalah index data dan $zw adalah clusternya
				// echo $z[$i]."=++".$zw."<br>";
				$idx_data[] = $z[$i];
				$idx_cluster[] = $zw;
				$zx = 0;
				$idxgab[$z[$i]] = $clusterAssignments[$zw];
			}
			$zw = $zw + 1;
			// echo "</pre>";
		}
		
		
        $data = ['hsl'=>$hsl,'jml_cluster'=>$k,'idx_data'=>$idx_data,'idx_cluster'=>$idx_cluster,'identitas'=>$identitas,'dtXYZ'=>$dtXYZ,'ttl'=>$ttl];
        // var_dump($identitas);
        return view('cluster/clusterbiaya',$data);
        
    }

}
