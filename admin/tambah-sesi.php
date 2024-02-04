<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['tipepengguna']!='a'){
            header("location: ../masuk.php");
        }

    }else{
        header("location: ../masuk.php");
    }
    
    
    if($_POST){
        //import database
        include("../koneksi.php");
        $judul=$_POST["judul"];
        $dokid=$_POST["dokid"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        $sql="insert into jadwal (dokid,judul,jadwaltgl,jadwalwaktu,nop) values ($dokid,'$judul','$date','$time',$nop);";
        $result= $database->query($sql);
        header("location: jadwal.php?action=session-added&judul=$judul");
        
    }
    ?>