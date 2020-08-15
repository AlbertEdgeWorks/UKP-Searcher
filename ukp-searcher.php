<?php
	//This File is Created By : Albert O
	//Re-using without permision is prohibited !
	//This file was developed from lecture projects.(PemJar/TOS)
	
    $cari="";
    if(isset($_GET['cari'])){
        $cari = $_GET['cari'];
    }else{
        $cari="";
    }

    $sJohn="";
    $sPeter="";
    if(isset($_GET['server'])){
        if($_GET['server']=="john"){ $sJohn="selected"; }
        else {$sPeter="selected";}
    }
?>
<html>
<head>
    <title>UKP User Directory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <style>
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 60px;
        }
        .footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px;
            line-height: 60px;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
<div class="container">
    <form method="GET" action="UKP_SEARCHER2.php">
        <div class="form-row">
            <div class="form-group col">
                <label for="pencarian">Name/NRP/ID Staff</label>
                <input type="text" class="form-control" id="pencarian" placeholder="Nama/NRP/NIK" name="cari" value="<?php echo $cari; ?>">
            </div>
            <div class="form-group col-md-2">
                <label for="tipe">Type</label>
                <select class="form-control" id="tipe" name="server">
                    <option value="john" <?php echo $sJohn; ?> >Student</option>
                    <option value="peter" <?php echo $sPeter; ?>>Lecturer</option>
                </select>
            </div>
        </div>
        <label>Partial search supported!</label>
        <label>Example : Type "m26416" to search informatics student year 2016 or type "c14" to search informatics student year >= 2017</label>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>
<div class="container">

<?php
    $error = 0;
    if(isset($_GET['cari'])){
        if(isset($_GET['server'])){
            $cari = $_GET['cari'];
            $server = $_GET['server'];
            if($server=='john'&&$cari!=""){
                echo "<title>UKP Searcher - ".$cari."@".$server."</title>";
                $url = 'http://john.petra.ac.id/~justin/finger.php?s='.$cari;
                $json = file_get_contents($url);
                //echo $json;
                $data =  json_decode($json);
                $isi = $data->hasil;
                echo '<strong>Found '.count($isi).' users.</strong>';
                $i=0;
                echo '<table class="table">
                <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">NRP</th>
                      <th scope="col">Check SKKK</th>  
                    </tr>
                  </thead>
                  <tbody>';
                while($i < count($isi)){
                    echo "<tr>";
                    $jumTal = $i+1;
                    echo "<td>".$jumTal."</td>";
                    echo "<td>".$isi[$i]->nama."</td>";
                    echo "<td>".$isi[$i]->login."</td>";
                    $nrp = $isi[$i]->login;
                    if($nrp[0]=="m"||$nrp[0]=="M"){
                        $nrp = substr($isi[$i]->login, 1);
                    }
                    else{

                    }
                    echo '<td><form target="_blank" style="text-align: center;" action="http://sportfolio.petra.ac.id/bakabootsrap/baka/skkk.php" method="post">
                        <input type="text" name="nrp" value='.$nrp.' hidden>
                        <button  type="Submit" name="Submit">CHECK SKKK</button>
                    </form></td>';
                    $i=$i+1;
                    echo "</tr>";
                }
                echo '
                </tbody>
                </table>';

            }else if($server=='peter'&&$cari!=""){
                
                echo "<title>UKP Searcher - ".$cari."@".$server."</title>";
                $url = 'http://peter.petra.ac.id/~justin/finger.php?s='.$cari;
                $json = file_get_contents($url);
                //echo $json;
                $data =  json_decode($json);
                $isi = $data->hasil;
                echo '<strong>Found '.count($isi).' users.</strong>';
                $i=0;
                echo '<table class="table">
                <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">NIK</th>
                    </tr>
                  </thead>
                  <tbody>';
                while($i < count($isi)){
                    echo "<tr>";
                    $jumTal = $i+1;
                    echo "<td>".$jumTal."</td>";
                    echo "<td>".$isi[$i]->nama."</td>";
                    echo "<td>".$isi[$i]->login."</td>";
                    $i=$i+1;
                    echo "</tr>";
                }
                echo '
                </tbody>
                </table>';
            }else{
                $error = 1;
            }
        }else{
            $error = 1;
        }
    }else{
        $error = 1;
    }

    if($error==1){
        echo '<div class="alert alert-warning" role="alert">
        Please Fill The Form Above !
      </div>';
    }else{

    }
    ?>
</tbody>
</table>
</div>
<footer class="footer">
      <div class="container">
        <span class="text-muted">By : Albert O 26416113</span>
      </div>
</footer>
</body>
