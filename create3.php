

<html>
<head> 
<link rel="shortcut icon" href="https://myfuzzyfriends.000webhostapp.com/favicon.ico" type="image/x-icon">
<link href="https://myfuzzyfriends.000webhostapp.com/stylesheet.css" rel="stylesheet" title="stylesheet">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Create A Fuzzy Friend</title>

    <script type="text/javascript">
		function getXMLHttp()
{
  var xmlHttp

  try
  {
    //Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    //Internet Explorer
    try
    {
      xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
    }
    catch(e)
    {
      try
      {
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
      }
      catch(e)
      {
        alert('Your browser does not support AJAX!')
        return false;
      }
    }
  }
  return xmlHttp;
}
//Update the values of the creature genetics
function updateGenetics(value, value1, value2, value3)
{
  var xmlHttp = getXMLHttp();
  
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      geneResponse(xmlHttp.responseText);
    }
  }
  xmlHttp.open('GET', 'https://myfuzzyfriends.000webhostapp.com/gene.php?g1='+ value +'&g2='+ value1 +'&g3='+ value2 +'&g4='+ value3 +'', true);
  xmlHttp.send(null);
}
function geneResponse(response)
{
	var txt = response
    var txtArr = txt.split('^^^')
    document.getElementById('geneDiv').innerHTML=txtArr[0];
	document.getElementById('geneticImageDiv').innerHTML=txtArr[1];

}
function updateEyes(value, value1)
{
  var xmlHttp = getXMLHttp();
  
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      eyeResponse(xmlHttp.responseText);
    }
  }
  xmlHttp.open('GET', 'https://myfuzzyfriends.000webhostapp.com/eyegenes.php?g1='+ value +'&g2='+ value1 +'', true);
  xmlHttp.send(null);
}
function eyeResponse(response)
{
	var txt = response
    var txtArr = txt.split('^^^')
    document.getElementById('geneDiv').innerHTML=txtArr[0];
	document.getElementById('geneticEyeDiv').innerHTML=txtArr[1];

}
function updateMouth(value, value1)
{
  var xmlHttp = getXMLHttp();
  
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      mouthResponse(xmlHttp.responseText);
    }
  }
  xmlHttp.open('GET', 'https://myfuzzyfriends.000webhostapp.com/mouth.php?g1='+ value +'&g2='+ value1 +'', true);
  xmlHttp.send(null);
}
function mouthResponse(response)
{
	var txt = response
    var txtArr = txt.split('^^^')
    document.getElementById('geneDiv').innerHTML=txtArr[0];
	document.getElementById('geneticMouthDiv').innerHTML=txtArr[1];

}

//handle base colors
function baseColor1(gene){
	updateGenetics('yes', gene, gene, gene);

}
function baseColor2(gene){
	updateGenetics(gene, 'yes',  gene, gene);
}
function baseColor3(gene){
	updateGenetics(gene, gene,  'yes', gene);
}
function baseColor4(gene){
	updateGenetics(gene, gene,  gene, 'yes');
}
function eyeColor1(gene){
	updateEyes('yes', gene);

}
function eyeColor2(gene){
	updateEyes(gene, 'yes');
}
function mouthColor1(gene){
	updateMouth('yes', gene);

}
function mouthColor2(gene){
	updateMouth(gene, 'yes');
}
    </script>


</head>
<div id='titleCreate'><br><b>Create A Fuzzy Creature </b></div>

<body>

    <br><br><center>
	<div id='pageDiv'><div id="dnapl"><img src="https://myfuzzyfriends.000webhostapp.com/dnapleft.png"></div><div id="dnapr"><img src="https://myfuzzyfriends.000webhostapp.com/dnaproght.png"></div><br><div id="creatureFlexCreate">
		<div id='creatureButtons'>
			<div id='bodyColorText'>The buttons below change the appearance of your creature! Mix and match to see how dominance works!</div>
				<div id='creatureColorButtons'>
					Red gene 1:<br><div id='creatureColorButtons'><input type='button' value='R' onclick="baseColor1('R')"></input><input type='button' value='r' onclick="baseColor1('r')"></input>
					<br></div>
					Red gene 2:<div id='creatureColorButtons'><input type='button' value='R' onclick="baseColor2('R')"></input><input type='button' value='r' onclick="baseColor2('r')"></input></div></div>
					<div id='creatureColorButtons'>
					Blue gene 1:
					<div id='creatureColorButtons'><input type='button' value='B' onclick="baseColor3('B')"></input><input type='button' value='b' onclick="baseColor3('b')"></input><br></div>
					Blue gene 2:
					<div id='creatureColorButtons'><input type='button' value='B' onclick="baseColor4('B')"></input>	<input type='button' value='b' onclick="baseColor4('b')"></input></div>
					</div>
				<div id='creatureColorButtons'>
					Eye gene 1:<br><div id='creatureColorButtons'><center><input type='button' value='R+' onclick="eyeColor1('R')"></input><input type='button' value='S' onclick="eyeColor1('S')"></input>
					<input type='button' value='C' onclick="eyeColor1('C')"></input>
					</center></div>Eye gene 2:<br><div id='creatureColorButtons'><center><input type='button' value='R+' onclick="eyeColor2('R')"></input><input type='button' value='S' onclick="eyeColor2('S')"></input>
					<input type='button' value='C' onclick="eyeColor2('C')"></input></center>
					</div></div>
				<div id='creatureColorButtons'>
					Mouth Genes:<br><div id='creatureColorButtons'><center><input type='button' value='M' onclick="mouthColor1('M')"></input><input type='button' value='m' onclick="mouthColor1('m')"></input>
					<input type='button' value='M' onclick="mouthColor2('M')"></input><input type='button' value='m' onclick="mouthColor2('m')"></input>
					</center></div></div>
			</div>

 <?php
echo '<div id="creatureDiv"> <div class="imageWrapper">';
$servername = "localhost";
$username   = "id4437658_fuzzydatabase";
$password   = "thisisapassword123";
$dbname     = "id4437658_fuzzycreatures_db";
$conn       = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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

echo "<div id='geneticImageDiv'></div><div id='geneticEyeDiv'>";
$eyetype = "{$creature['eye_type']}{$creature['eye_color']}";
if ($eyetype == 'RR' || $eyetype == 'RS' || $eyetype == 'SR' || $eyetype == 'RC' || $eyetype == 'CR') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/roundeyes.png"></img>';
} else if ($eyetype == 'SS' || $eyetype == 'SC' || $eyetype == 'CS') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/sadeyes.png"></img>';
} else {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/cateyes.png"></img>';
}
echo "</div><div id='geneticMouthDiv'>";
$mouthtype = "{$creature['mouth_size']}{$creature['mouth_type']}";
if ($mouthtype == 'MM') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/sqaremouth.png"></img>';
} else if ($mouthtype == 'mM' || $mouthtype == 'Mm') {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/roundmouth.png"></img>';
} else {
    echo '<img class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/sharpmouth.png"></img>';
}
echo '</div><img id="image2" class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/fuzzylineart.png"></img>
</div></div></div>  <br>
 <b>Creature Genome:</b><div id="geneticDiv">Select one of the options next to your creature to see how it changes!</div><div id="geneDiv">';

echo "Your creatures current genetic code is : {$furcolor}{$eyetype}{$mouthtype}!";
echo '</div>';

?><br>
<br>
 <div id='pageText'><img src='https://myfuzzyfriends.000webhostapp.com/masco.png'></img>Welcome to Fuzzy Friends! <br>A gene is a part of DNA that has a special job. Your body has many genes that help determine your traits. These traits are called your phenotype. Different people often have different versions of genes. These are called alleles. Each pair of alleles results in a different trait. If the alleles are the same, then it is homozygous. If the alleles are different, it is heterozygous. Your specific pair of alleles for each trait is the genotype. Design your own fuzzy friend’s phenotype and see how their traits are affected by the different genotypes!
<br><br></div></body>

</html>