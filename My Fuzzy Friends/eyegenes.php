<html>

 <head>

  <title>My Fuzzy Friends . COM</title>

 </head>

 <body>

 <?php
//get the creature data from the Database, post it here. Update as needed.
$g1         = $_GET["g1"];
$g2         = $_GET["g2"];
$servername = "localhost";
$username   = "id4437658_fuzzydatabase";
$password   = "thisisapassword123";
$dbname     = "id4437658_fuzzycreatures_db";
$conn       = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($g1 == 'yes') {
    $sql = "UPDATE fuzzy_creatures SET eye_type='{$g2}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's first eye type gene is now coded as {$g2}!<br><br> Your creatures full genetic code is now ";
        $sql = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        
        $result   = $conn->query($sql);
        $creature = $result->fetch_assoc();
        $furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
        
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
		echo '<br>The eye gene is the result of classic Mendelian genetics. In simple Mendelian genetics, there are two different kinds of alleles: dominant (R+) and recessive (S and C), and there are three types of phenotypes. In this gene, the phenotypes are round eyes, cat eyes and sad eyes. The genetic combination of RR results in round eyes, but SR and RC also result in round eyes because the R+ is dominant to the S and C genes. The cat eyes are only possible if the genotype is CC, the homozygous recessive genotype.';    } else {
        echo "Error updating record: " . $conn->error;
    }
} else if ($g2 == 'yes') {
    $sql = "UPDATE fuzzy_creatures SET eye_color='{$g1}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's second eye type gene is now coded as {$g1}!<br><br> Your creatures full genetic code is now ";
        $sql = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        
        $result   = $conn->query($sql);
        $creature = $result->fetch_assoc();
        $furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
        
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
        
		echo '<br>The eye gene is the result of classic Mendelian genetics. In simple Mendelian genetics, there are two different kinds of alleles: dominant (R+) and recessive (S and C), and there are three types of phenotypes. In this gene, the phenotypes are round eyes, cat eyes and sad eyes. The genetic combination of RR results in round eyes, but SR and RC also result in round eyes because the R+ is dominant to the S and C genes. The cat eyes are only possible if the genotype is CC, the homozygous recessive genotype.';
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

echo "^^^";
$sql      = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color FROM fuzzy_creatures WHERE fid=1";
$result   = $conn->query($sql);
$creature = $result->fetch_assoc();
$eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
if ($eyetype == 'RR' || $eyetype == 'RS' || $eyetype == 'SR' || $eyetype == 'RC' || $eyetype == 'CR') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/roundeyes.png"></img>';
} else if ($eyetype == 'SS' || $eyetype == 'SC' || $eyetype == 'CS') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/sadeyes.png"></img>';
} else {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/cateyes.png"></img>';
}

$conn->close();

?> 

 </body>

</html>