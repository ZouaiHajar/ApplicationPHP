<!DOCTYPE html>
<html>
<head>
	<title>Login Server</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style type="text/css">
		body{
			padding: 0;
			margin: 0;
			font-family: Verdana , Geneva ,Tahoma ,sans-serif;
		}
		table{
			
			border-collapse: collapse;
			width: 800px;
			height: 200px;
			border: 1px solid black;
			box-shadow: 2px 2px 12px rgba(0,0,0,0.2), -1px -1px 8px rgba(0,0,0,0.2);
		}
		tr{
			transition: all 2s ease-in;
			cursor: pointer;
		}
		th , td{
			padding: 12px;
			text-align: left;
			border-bottom: 1px solid #ddd;

		}
		#header{
			background-color:orange;
		}
		tr:hover{
			background-color: #f5f5f5;
			transform: scale(1.02);
			box-shadow: 2px 2px 12px rgba(0,0,0,0.2), -1px -1px 8px rgba(0,0,0,0.2);
		}
		#p{
			color: red;
		}
		#print-btn{
			background-color: #00FFFF;
            font-size: 16px;
            padding: 14px 40px;
            border-radius: 12%;
            border: 2px solid black;
            transition-duration: 0.4s;
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
		}
		#print-btn:hover{
			background-color: orange;
			box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
		}
	</style>

</head>
<body>

<?php

$serveur="localhost";
$login="root";
$pass="";
$connexion=new PDO("mysql:host=$serveur;dbname=gestion_ventes",$login,$pass);
$connexion->setattribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$val = $_POST["val"];
if($val == 1){

$CodeC = $_POST["codeclient"];	
$DateC = $_POST["date"];



 $selection=("SELECT *FROM `ligne_commande` natural join client natural join produit natural join commande where  Code_Client = $CodeC 
 	and DATEDIFF(Date , '$DateC')>=0  ");
 $R1=$connexion->prepare($selection);
 $R1->execute();
 $R1=$R1->fetchall();

 $selection=("SELECT DISTINCT Numéro_Commande FROM `ligne_commande` natural join client natural join produit natural join commande where  Code_Client = $CodeC and DATEDIFF(Date , '$DateC')>=0 ");
 $R2=$connexion->prepare($selection);
 $R2->execute();
 $R2=$R2->fetchall();



 $s=0;
 for($i=0;$i<count($R1);$i++){
 	$id=$R1[$i]["Code_Client"];
     if($CodeC == $id){
        $s=1;
        $name= $R1[$i]["Nom"];
     }
 }
 if($s == 1){
 	$valTot =0;
 	
      echo "<div class='E'><center>";
      echo "<h3>Code Client  : $CodeC ............. Nom Client : $name</h3>";
   	echo "<h3>A partir de : $DateC </h3>";
      echo "<table class='content-table' border=8><tr id='header'><th>N°Commande</th><th>Date</th><th>Code Prd</th><th>Désignation</th><th>PU</th>
			<th>Qte</th><th>Tot PRD</th></tr>";

            
            
                    $chifreT = 0;

                 for($j=0;$j<count($R2);$j++){
                 	$u=0;
                 	$valTot=0;
                 	$num=$R2[$j]['Numéro_Commande'];
                          for($i=0;$i<count($R1);$i++){
                                 if ($R1[$i]['Numéro_Commande']== $R2[$j]['Numéro_Commande']) {
                                 	$u=$u+1;
                                 }
                 
                            }
                            $o=$u;
                      echo "<tr><td rowspan= $o>";
 	                  echo $R2[$j]['Numéro_Commande'];
 	                  echo "</td>";
 	                  echo "<td rowspan=$o>";
 	                echo $R1[$j]['Date'];
 	                echo "</td>";
 	                for($i=0;$i<count($R1);$i++){
 	              	 if ($R1[$i]['Numéro_Commande'] == $num) {
                    
 	                echo "<td>";
 	                echo $R1[$i]['Code_Produit'];
 	                echo "</td><td>";
 	                echo $R1[$i]['Désignation'];
 	                echo "</td><td>";
 	                echo $R1[$i]['Prix_Unitaire'];
 	                echo "</td><td>";
 	                echo $R1[$i]['Qte'];
 	                echo "</td><td>";
 	                echo ($R1[$i]["Prix_Unitaire"]*$R1[$i]["Qte"]);
 	                echo "</td></tr>";
 	                $valTot = $valTot+($R1[$i]["Prix_Unitaire"]*$R1[$i]["Qte"]);
                    }
 	              	
                  }
                   echo "<tr><td colspan=7 bgcolor='#FFFF00'>";
                   echo "Totale Commande Num ";
                   echo $R2[$j]['Numéro_Commande'];
                   echo "    :";
 	                echo $valTot;
 	                echo "</td></tr>";
                   $chifreT =  $chifreT +$valTot;
                 }

 	  




      echo "</table>";  
      echo "<h2>Chiffre d'affaire du client (" ;
      echo $R1[0]["Code_Client"];
      echo "_";
      echo $R1[0]["Nom"];
      echo ") :";
      echo   $chifreT;
      echo "</h2></center></div>" ;   
 }
 if($s == 0){
$selection=(" SELECT * FROM `client` where Code_Client = $CodeC");
$R3=$connexion->prepare($selection);
$R3->execute();
$R3=$R3->fetchall();
    echo "<center><h3 id=p>Code Client :$CodeC ........... Nom Client :";
    echo $R3[0]["Nom"];
    echo "</br>";
 	echo "le client ";
 	echo" de code $CodeC n'a pas passé de commandes à partir de la date  $DateC </h3> ";
 	
 }
 
}

if($val == 2){

$DateG =$_POST["dateG"];


$selection=(" SELECT * FROM `client` ");
$R3=$connexion->prepare($selection);
$R3->execute();
$R3=$R3->fetchall();

$selection=("SELECT *FROM `ligne_commande` natural join client natural join produit natural join commande where  DATEDIFF(Date , '$DateG')>=0 ");
$R2=$connexion->prepare($selection);
$R2->execute();
$R2=$R2->fetchall();





$selection=("SELECT DISTINCT Numéro_Commande FROM `ligne_commande` natural join client natural join produit natural join commande where  DATEDIFF(Date , '$DateG')>=0; ");
 $R1=$connexion->prepare($selection);
 $R1->execute();
 $R1=$R1->fetchall();

$l = 0;
if( !empty($R2[0]["Date"] ) ){
$l = 1;
}


if($l == 1){

echo "<div class='E'><center><h2>Chiffre d'affaire global -GestCom </br></h2>
<h2> A partir de :$DateG </h2>
     <table border=1>
     <tr id='header'>
     <th>Code Client</th>
     <th>Nom Client</th>
     <th>N°Commande</th>
     <th>Date</th><th>
     Code Prd</th><th>
     Désignation</th>
     <th>PU</th>
	 <th>Qte</th>
     <th>Tot PRD</th>
     </tr>";
$chifreG = 0;
for($i=0;$i<count($R3);$i++){

     $val = $R3[$i]["Code_Client"];
     $naame =$R3[$i]["Nom"]; 
     $ct = 0;
     $row = 0;
     $b = 0;
     $lo=0;
         for ($j=0;$j<count($R2);$j++){ 
	          if( $R2[$j]["Code_Client"] == $val ){
                  $row = $row+1;     
                  $b = 1;
            	  }
           }


$selection=("SELECT DISTINCT Numéro_Commande FROM `ligne_commande` natural join client natural join produit natural join commande where  DATEDIFF(Date , '$DateG')>=0 and  Code_Client = $val ");
 $R4=$connexion->prepare($selection);
 $R4->execute();
 $R4=$R4->fetchall();


      
      if ($b == 1) {
       $lo = ($row)+1+count($R4);
        echo "<tr><th rowspan = $lo>";
        echo $R3[$i]["Code_Client"];
        echo "</th>";
        echo "<td rowspan = $lo>";
        echo $R3[$i]["Nom"];
        echo "</td>";
                                            $total =0 ;
                           
                                             for ($k=0; $k <count($R1); $k++) {
                                             $p=0;
                                             $ct = 0;

                                             	for ($q=0; $q <count($R2) ; $q++) { 
                                             		if ($R2[$q]["Code_Client"] == $val && $R1[$k]['Numéro_Commande']== $R2[$q]["Numéro_Commande"] ) {
                                             			    $daat = $R2[$q]['Date'];
                                             				$p=$p+1;
                                             			
                                             		}
                                             	}

                                             	if ($p > 0) {
                                             		$s = ($p)+1;
                                             		echo "<tr><td rowspan= '$s'>";
 	                                                echo $R1[$k]['Numéro_Commande'];
 	                                                echo "</td>";
 	                                                $z= $s-1;
                                             		echo "<td rowspan='$z'>";
 	                                                             echo $daat;
 	                                                             echo "</td>";
                                            
                                                       for ($j=0; $j <count($R2) ; $j++) { 

                                                       	         if ($R1[$k]['Numéro_Commande'] == $R2[$j]["Numéro_Commande"]) {
                                                       	         	
                                                       	         
 	                                                             echo "<td>";
 	                                                             echo $R2[$j]['Code_Produit'];
 	                                                             echo "</td><td>";
 	                                                             echo $R2[$j]['Désignation'];
 	                                                             echo "</td><td>";
 	                                                             echo $R2[$j]['Prix_Unitaire'];
 	                                                             echo "</td><td>";
 	                                                             echo $R2[$j]['Qte'];
 	                                                             echo "</td><td>";
 	                                                             echo ($R2[$j]["Prix_Unitaire"]*$R2[$j]["Qte"]);
 	                                                             echo "</td></tr>";
 	                                                             //echo "<tr><td colspan='6' bgcolor='#00FFFF'> Total commande N° :";
 	                                                             //echo ($R2[$j]["Prix_Unitaire"]*$R2[$j]["Qte"]);
 	                                                             //echo "</td></tr>";
                                                               $ct = $ct + ($R2[$j]["Prix_Unitaire"]*$R2[$j]["Qte"]);
                                                       	         }
                                                       	        
                                                       }
                                                          echo "<tr><td colspan='6' bgcolor='#FFFF00' >Totale commande Num ";
      	                                                         echo $R1[$k]['Numéro_Commande'];
      	                                                         echo "  :";
 	                                                             echo $ct;
 	                                                             echo "</td></tr>";
                                                              	
                                                      
                                                        $total = $total +$ct;






                                             	}


                                             }
                                            echo "<tr><td colspan ='9' bgcolor='#00FFFF'>";
                                            echo "Chiffre d'affaire Client ( $val - $naame ) : ";
                                            echo $total;
                                            echo"</td></tr>";
        
       
      	 $chifreG = $chifreG + $total;
	   }  
                 
     
}
    echo "</table>";
    echo "<h3>Chiffre d'affaire Global - GestCom : ";
    echo $chifreG;
    echo "</h3></center></div>";
    
    

}else{
	echo "<center><h2 id=p>Pas de commandes passées après la date";
	echo $DateG;
	echo "</h2>";
}


 





}

?>
<center>
<button onclick="window.print();" class="btn btn-primary" id="print-btn">IMPRIMER</button>
</center>
</br>
</body>
</html>