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
    $sql = "UPDATE fuzzy_creatures SET mouth_type='{$g2}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's first mouth type gene is now coded as {$g2}!<br><br> Your creatures full genetic code is now ";
        
        $sql      = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        $result   = $conn->query($sql);
        $creature = $result->fetch_assoc();
        $furcolor = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype  = "{$creature['eye_type']}{$creature['eye_color']}";
        
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
        echo"<br>Incomplete dominance is when the heterozygote produces a new phenotype. This phenotype is a mixture of each contributing allele. In the mouth gene, the alleles are square teeth and sharp teeth- producing a round intermediate.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else if ($g2 == 'yes') {
    $sql = "UPDATE fuzzy_creatures SET mouth_size='{$g1}' WHERE fid=1";
    
    if ($conn->query($sql) === TRUE) {
        echo "Your creature's second eye type gene is now coded as {$g1}!<br><br> Your creatures full genetic code is now ";
        $sql       = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color FROM fuzzy_creatures WHERE fid=1";
        $result    = $conn->query($sql);
        $creature  = $result->fetch_assoc();
        $furcolor  = "{$creature['fur_color']}{$creature['fur_color2']}{$creature['fur_color3']}{$creature['fur_color4']}{$creature['eye_type']}{$creature['eye_color']}";
        $eyetype   = "{$creature['eye_type']}{$creature['eye_color']}";
        $sql       = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
        $result    = $conn->query($sql);
        $creature  = $result->fetch_assoc();
        $mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
        echo " {$furcolor}{$eyetype}{$mouthtype}.<br>";
        
    echo"<br>Incomplete dominance is when the heterozygote produces a new phenotype. This phenotype is a mixture of each contributing allele. In the mouth gene, the alleles are square teeth and sharp teeth- producing a round intermediate.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

echo "^^^";
$sql       = "SELECT fur_color,fur_color2,fur_color3,fur_color4,eye_type,eye_color,mouth_type,mouth_size FROM fuzzy_creatures WHERE fid=1";
$result    = $conn->query($sql);
$creature  = $result->fetch_assoc();
$mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
if ($mouthtype == 'MM') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/sqaremouth.png"></img>';
} else if ($mouthtype == 'mM' || $mouthtype == 'Mm') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/roundmouth.png"></img>';
} else {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/sharpmouth.png"></img>';
}

$conn->close();

?> 

 </body>

</html>