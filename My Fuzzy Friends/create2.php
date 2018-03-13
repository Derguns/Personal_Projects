<html>
<head> 

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
function updateGenetics(value, value1)
{
  var xmlHttp = getXMLHttp();
  
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      geneResponse(xmlHttp.responseText);
    }
  }
  xmlHttp.open('GET', 'https://myfuzzyfriends.000webhostapp.com/gene.php?g1='+ value +'&g2='+ value1 +'', true);
  xmlHttp.send(null);
}
function geneResponse(response)
{
	var txt = response
    var txtArr = txt.split('^^^')
    document.getElementById('geneDiv').innerHTML=txtArr[0];
	var x = document.getElementById("myDIV");
		var sourceOfPicture = txtArr[1];
		x.src = sourceOfPicture.replace('90x90', '225x225');
}


//handle base colors
function baseColor1(gene){
	updateGenetics('yes', gene);

}
function baseColor2(gene){
	updateGenetics(gene, 'yes');
}
    </script>


</head>
<div id='titleCreate'><br><b>Create A Fuzzy Creature </b></div>

<body>

    <br><br><center>
	<div id='pageDiv'><br><div id="creatureFlexCreate">
		<div id='creatureButtons'>
			<div id='bodyColorText'>The buttons below change the color of your creature! Mix and match colors to see how dominace works!</div>
				<div id='creatureColorButtons'>
					Color gene 1:<br><div id='creatureColorButtons'><center><input type='button' value='RR' onclick="baseColor1('RR')"></input><input type='button' value='Rr' onclick="baseColor1('Rr')"></input>
					<input type='button' value='rR' onclick="baseColor1('rR')"></input>	<input type='button' value='rr' onclick="baseColor1('rr')"></input>				
					</center></div>Color gene 2:<br>
					<div id='creatureColorButtons'><center><input type='button' value='BB' onclick="baseColor2('BB')"></input><input type='button' value='Bb' onclick="baseColor2('Bb')"></input>
					<input type='button' value='bB' onclick="baseColor2('bB')"></input>	<input type='button' value='bb' onclick="baseColor2('bb')"></input>				
					</center>
					</div></div>
			</div>

 <?php 
 echo '<div id="creatureDiv"> <div class="imageWrapper">';
 $servername = "localhost";
 $username = "id4437658_fuzzydatabase";
 $password = "thisisapassword123";
 $dbname = "id4437658_fuzzycreatures_db";
 $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT fur_color,fur_color2 FROM fuzzy_creatures WHERE fid=1";
$result = $conn->query($sql);
$creature = $result->fetch_assoc();
$furcolor = "{$creature['fur_color']}{$creature['fur_color2']}";

  if($furcolor == 'RRBB' || $furcolor == 'RrBB' || $furcolor == 'RrBb' || $furcolor == 'rRBB'
  || $furcolor == 'RRBb'  || $furcolor == 'RrbB' || $furcolor =='RRbB' || $furcolor =='rRbB' || $furcolor =='rRBb'){
  echo '<img id="image2" class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/fuzzyred.png"></img>';
       $src = 'https://myfuzzyfriends.000webhostapp.com/fuzzyred.png';
  }
  else if($furcolor == 'rrbb'){
  echo '<img id="image2" class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/fuzzyblue.png"></img>';
      	$src = 'https://myfuzzyfriends.000webhostapp.com/fuzzyblue.png';
 }
   else if($furcolor =='RRbb' || $furcolor =='rrBb' || $furcolor =='rrbB' || $furcolor == 'rrBB' || $furcolor =='Rrbb' || $furcolor =='rRbb'){
	echo '<img id="image2" class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/fuzzyyellow.png"></img>';	  
      	$src = 'https://myfuzzyfriends.000webhostapp.com/fuzzyyellow.png';
 }
 
  echo "<div id='geneticImageDiv'><img id='myDIV' class='overlayImage' src='{$src}' style='display:none;' /></div>";
  echo '<img id="image2" class="overlayImage" src="https://myfuzzyfriends.000webhostapp.com/fuzzylines.png"></img>
</div></div></div>
  <br>
 <b>Creature Genome:</b><div id="geneticDiv">Select one of the options next to your creature to see how it changes!</div><div id="geneDiv">';

echo "Your creatures current genetic code is : {$furcolor}!";
 echo '</div>';

 ?> <br>
<br>
 <div id='pageText'>Creating a fuzzy creature is not only fun- but also shows you how complex genes interact with each other to form a unique creature. Click the icons next to the creature to change his code, and hover over his genome to see how everything interacts! Chosing between Rb or rB will have an unknown effect on your creature's breeding capabilities- but not on its appearance! </div>
<br><br></div></body>

</html>