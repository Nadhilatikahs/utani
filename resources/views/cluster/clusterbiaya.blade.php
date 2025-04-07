@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <?php
        $warna = ['#7FFF00','#00008B','#FF1493','#4169E1','#FF6347','#EE82EE','#FFFF00','#8B0000','#3CB371','#BA55D3','#FAFAD2','#FFF0F5','#FFD700','#696969','#B8860B'];
        $warna_cluster = [];
        $cluster = [];
    ?>
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Cluster Biaya Tani</h1>
    </div>
    <hr />
    @if(Session::has('success'))
        <div id="flash-message"  class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    
    
    <div class="row">

        <div class="container">
            <form action="#" method="get">
            <div class="row justify-content-center">
                <div class="mb-3 row">
                    <label for="inputPassword6" class="col-sm-4 col-form-labell">Awal</label>
                    <div class="col-sm-8">
                        <input type="date" id="start_date" name="start_date">
                    </div>
                </div>
            </div>
    
            <div class="row justify-content-center">
                <div class="mb-3 row">
                    <label for="inputPassword6" class="col-sm-4 col-form-labell">Akhir</label>
                    <div class="col-sm-8">
                       <input type="date" id="end_date" name="end_date">
                    </div>
                </div>
            </div>
    
    
            <div class="row justify-content-center">
                <div class="mb-3 row">
                    <label for="inputPassword6" class="col-sm-4 col-form-labell">Cluster</label>
                    <div class="col-sm-8">
                        <select class="form-select" id="jml_cluster" name="jml_cluster" aria-label="Default select example" >
                            <?php 
                                for($i=1;$i<=10;$i++){
                                    ?>
                                        <option value=<?=$i?> <?=($i == $jml_cluster) ? "selected" : ""?>><?=$i?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
    
    
            <div class="row justify-content-center">
                <div class="mb-3 row">
                        <button class="btn btn-primary" type="submit" name="submit">Proses</button>
                </div>
            </div>
            </form>
            
        </div>
    
        <p></p>
        
        
    
        <?php
             if(isset($_GET['start_date'])){
                if(isset($_GET['end_date'])){
                    $start_date = $_GET['start_date'];
    	            $end_date = $_GET['end_date'];
    	            //echo $_GET['start_date'].'-'.$_GET['end_date']."<br>";
    	           // echo $start_date.'-'.$end_date."<br>";
                    // echo $_GET['jml_cluster'];
                    // echo "<br>";
                    // foreach ($hsl as $h) {
                    //     echo $h->rc."<br>";
                    // }
                    
                    $options = [0, 1,2,3,4,5,6,7,8,9,10]; // untuk clusternya

                    // sesuai jml cluster
                    $options2 = [];
                    for($i=0;$i<$_GET['jml_cluster'];$i++){
                        array_push($options2,$options[$i]);
                    }
                    
                    // dapatkan isi sumbu x, y, dan z
                    $sumbux = [];
                    $sumbuy = [];
                    $sumbuz = [];
                    $i=0;
                    foreach ($hsl as $h) {
                        $sumbuz[] = $h->rc;
                        $sumbux[] = $h->keuntungan;
                        $sumbuy[] = $h->beban_variabel + $h->beban_fix;
                        $idx = array_search($i, $idx_data);
                        $idx_cl = $idx_cluster[$idx];
                        $warna_cluster[] = $warna[$idx_cl];
                        $cluster[] = $options2[$idx_cl]; 
                        $i++;
                    }
                    ?>
                    
                    <br><br>
                    <div class="container">
                        <div class="d-flex justify-content-center">
                            <div id="container" style="width: 750px; height: 400px;"></div>
                        </div>    
                    </div>
                    
                    <br><br><br><br><p></p>
                    <div class="container">
                        <div>
                            -
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-2">
                                
                            </div>
                            <!---->
                            <div class="col-sm-8">
                                        <div class="card">
                                            <h6 class="card-header">Informasi Warna Cluster Periode <?php echo $start_date.' s/d '.$end_date?></h6>
                                            
                                            <ul class="list-group list-group-flush">
                                                <?php 
                                                    // for ($a=0;$a<count($options);$a++) {
                                                    
                                                        // masukkan ke array
                                                        function sortWithIndex($arr) {
                                                            // Buat array asosiatif dengan indeks asli dan nilai
                                                            $indexedArr = array();
                                                            foreach ($arr as $index => $value) {
                                                                $indexedArr[$index] = $value;
                                                            }

                                                            // Urutkan array secara menurun berdasarkan nilai
                                                            arsort($indexedArr);

                                                            // Ambil indeks hasil pengurutan
                                                            $sortedIndices = array_keys($indexedArr);

                                                            return $sortedIndices;
                                                        }
                                                    
                                                        $klm1 = []; //warna
                                                        $klm2 = []; //nama cluster
                                                        $klm3 = []; //list sekolah
                                                        $klm4 = [];
                                                        for ($a=0;$a<$_GET['jml_cluster'];$a++) {
                                                            $klm1[] =  $warna[$a];
                                                            $klm2[] = $options[$a];


                                                            $tmp = []; $total_ttl = 0; $jml_dt = 0;
                                                            for ($i = 0; $i < count($identitas); $i++){
                                                                if($cluster[$i]==$options[$a]){
                                                                    $tmp[] = $identitas[$i];
                                                                    $total_ttl = $total_ttl+$ttl[$i];
                                                                    $jml_dt =$jml_dt + 1;
                                                                }
                                                              }

                                                            $total_ttl = $total_ttl/$jml_dt;
                                                            sort($tmp); $ktmp = [];
                                                            for($i=0;$i<count($tmp);$i++){
                                                                $ktmp[] = $tmp[$i]; 
                                                            }

                                                            $klm3[] = $ktmp;

                                                            $klm4[] = round($total_ttl,2);

                                                        }
                                                        // $arr = array(5.3, 2.1, 9.7, 1.5, 5.0);
                                                        $sortedIndices = sortWithIndex($klm4);
                                                        
                                                    
                                                        for ($a=0;$a<$_GET['jml_cluster'];$a++) {
                                                        ?>
                                                            <li class="list-group-item">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-2"><div style="background: <?=$warna[$sortedIndices[$a]]?>; text-align: center;" zn_id="139">.</div></div>
                                                                        <div class="col-2">Cluster <?=$options[$sortedIndices[$a]]?></div>
                                                                        <div class="col-6">
                                                                            @php
                                                                                $tmp = []; $total_ttl = 0; $jml_dt = 0;
                                                                            @endphp
                                                                            <?php for ($i = 0; $i < count($identitas); $i++){
                                                                                    if($cluster[$i]==$options[$sortedIndices[$a]]){
                                                                                        $tmp[] = $identitas[$i];
                                                                                        $total_ttl = $total_ttl+$ttl[$i];
                                                                                        $jml_dt =$jml_dt + 1;
                                                                                    }
                                                                                  }

                                                                                  $total_ttl = $total_ttl/$jml_dt;
                                                                                    sort($tmp);
                                                                                    for($i=0;$i<count($tmp);$i++){
                                                                                        echo $tmp[$i]."<br>"; 
                                                                                    }
                                                                                    // perhitungan per cluster

                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <div class="col-2"><?=round($total_ttl,2)?></div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </li>
                                                        <?php
                                                    }
                                                ?>
                                            </ul> 
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                    
                                    </div>
                            <!---->
                        </div>
                    </div>
                    
                    <!---->
                    <script>
                                // Configuration for chart
                                var chartOptions = {
                                    chart: {
                                        type: 'scatter',
                                        renderTo: 'container',
                                        options3d: {
                                            enabled: true,
                                            alpha: 10,
                                            beta: 30,
                                            depth: 250,
                                            viewDistance: 5,
                                            fitToPlot: false,
                                            frame: {
                                                bottom: { size: 1, color: 'rgba(0,0,0,0.02)' },
                                                back: { size: 1, color: 'rgba(0,0,0,0.04)' },
                                                side: { size: 1, color: 'rgba(0,0,0,0.06)' }
                                            }
                                        }
                                    },
                                    title: {
                                        text: 'Visualisasi Cluster '
                                    },
                                    xAxis: {
                                        title: {
                                            text: 'Keuntungan'
                                        }
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Beban'
                                        }
                                    },
                                    zAxis: {
                                        title: {
                                            text: 'R/C'
                                        }
                                    },
                                    plotOptions: {
                                        scatter: {
                                            width: 10,
                                            height: 10,
                                            depth: 10,
                                            colorByPoint: true
                                        }
                                    },
                                    legend: {
                                        enabled: true
                                    },
                                    series: [{
                                        name: 'Data',
                                        data: <?php echo json_encode($dtXYZ);?>,
                                        keys: ['x', 'y', 'z'],
                                        colorByPoint: true,
                                    }],
                                    colors: <?php echo json_encode($warna_cluster);?>
                                };

                                // Create chart
                                var chart = new Highcharts.Chart(chartOptions);

                            </script>
                    <!---->
                    
                    <?php
                }
             }    
        ?>
        
    </div>
    <br>
@endsection
