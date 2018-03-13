<html>

 <head>

  <title>My Fuzzy Friends . COM</title>

 </head>

 <body>

 <?php
//get the creature data from the Database, post it here. Update as needed.
$g1         = $_GET["g1"];
$g2         = $_GET["g2"];
$g3         = $_GET["g3"];
$g4         = $_GET["g4"];
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
    $sql = "UPDATE fuzzy_creatures SET fur_color='{$g2}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's first fur color gene is now coded as {$g2}!<br><br> Your creatures full genetic code is now ";
        $sql      = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        $result   = $conn->query($sql);
        $creature = $result->fetch_assoc();
        $furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
        
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
            echo "<br>In codominance for the fur color gene, there are three alleles: fcr, fcb, and fcy. The red fur phenotype results from a fcr /fcr genotype. The blue fur phenotype results from a fcb /fcb genotype. And the yellow fur phenotype results from a fcy/ fcy genotype. But when there is a fcr/ fcb heterozygote, codominance is demonstrated and the fur color is red with blue spots. fcy is recessive to fcr and fcb, so a fcy heterozygote with either of the other alleles will have the phenotype of that other allele.";

    } else {
        echo "Error updating record: " . $conn->error;
    }
} else if ($g2 == 'yes') {
    $sql = "UPDATE fuzzy_creatures SET fur_color2='{$g1}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's second fur color gene is now coded as {$g1}!<br><br> Your creatures full genetic code is now ";
        $sql = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        
        $result   = $conn->query($sql);
        $creature = $result->fetch_assoc();
        $furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
        
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
            echo "<br>In codominance for the fur color gene, there are three alleles: fcr, fcb, and fcy. The red fur phenotype results from a fcr /fcr genotype. The blue fur phenotype results from a fcb /fcb genotype. And the yellow fur phenotype results from a fcy/ fcy genotype. But when there is a fcr/ fcb heterozygote, codominance is demonstrated and the fur color is red with blue spots. fcy is recessive to fcr and fcb, so a fcy heterozygote with either of the other alleles will have the phenotype of that other allele.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else if ($g3 == 'yes') {
    $sql = "UPDATE fuzzy_creatures SET fur_color3='{$g2}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's third fur color gene is now coded as {$g2}!<br><br> Your creatures full genetic code is now ";
        $sql = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        
        $result   = $conn->query($sql);
        $creature = $result->fetch_assoc();
        $furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
        
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
            echo "<br>In codominance for the fur color gene, there are three alleles: fcr, fcb, and fcy. The red fur phenotype results from a fcr /fcr genotype. The blue fur phenotype results from a fcb /fcb genotype. And the yellow fur phenotype results from a fcy/ fcy genotype. But when there is a fcr/ fcb heterozygote, codominance is demonstrated and the fur color is red with blue spots. fcy is recessive to fcr and fcb, so a fcy heterozygote with either of the other alleles will have the phenotype of that other allele.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $sql = "UPDATE fuzzy_creatures SET fur_color4='{$g1}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's fourth fur color gene is now coded as {$g1}!<br><br> Your creatures full genetic code is now ";
        $sql = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        
        $result   = $conn->query($sql);
        $creature = $result->fetch_assoc();
        $furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
        
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
            echo "<br>In codominance for the fur color gene, there are three alleles: fcr, fcb, and fcy. The red fur phenotype results from a fcr /fcr genotype. The blue fur phenotype results from a fcb /fcb genotype. And the yellow fur phenotype results from a fcy/ fcy genotype. But when there is a fcr/ fcb heterozygote, codominance is demonstrated and the fur color is red with blue spots. fcy is recessive to fcr and fcb, so a fcy heterozygote with either of the other alleles will have the phenotype of that other allele.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
echo "^^^";
$sql      = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
$result   = $conn->query($sql);
$creature = $result->fetch_assoc();
$furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}";

if ($furcolor == 'RRBB' || $furcolor == 'RrBB' || $furcolor == 'RrBb' || $furcolor == 'RrBB' || $furcolor == 'RRBb' || $furcolor == 'RRBb' || $furcolor == 'rRBB' || $furcolor == 'RRbB' || $furcolor == 'RrbB' || $furcolor == 'rRBb' || $furcolor == 'rRbB') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/bluered.png"></img>';
    $src = 'https://myfuzzyfriends.000webhostapp.com/bluered.png'; //make spots
} else if ($furcolor == 'rrbb') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/fluffyellow.png"></img>';
    $src = 'ttps://myfuzzyfriends.000webhostapp.com/fluffyellow.png';
} else if ($furcolor == 'RRbb' || $furcolor == 'Rrbb' || $furcolor == 'rRbb') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/red.png"></img>';
    $src = 'https://myfuzzyfriends.000webhostapp.com/red.png';
} else if ($furcolor == 'rrBb' || $furcolor == 'rrbB' || $furcolor == 'rrBB') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/blue.png"></img>';
    $src = 'https://myfuzzyfriends.000webhostapp.com/blue.png';
}


$conn->close();

?> 

 </body>

</html>