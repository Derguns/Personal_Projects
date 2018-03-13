<html>

 <head>

  <title>My Fuzzy Friends . COM</title>

 </head>

 <body>

 <?php 
 //get the creature data from the Database, post it here. Update as needed.
 $action = $_GET["action"];

 if($action == 'albino'){
 echo "Your creature has no pigment genes! That means that they are an albino- white and pink with red eyes!"; 
 }
 if($action == 'mela'){
 echo "Your creature has too many pigment genes! That means that they are melanistic- their features will all be black!"; 
 }
 if($action == 'blue'){
 echo "Your creature is currently homozygous blue."; 
 }
 if($action == 'red'){
 echo "Your creature is currently homozygous red."; 
 }
 if($action == 'yellow'){
 echo "Your creature is currently homozygous yellow."; 
 }
 if($action == 'bluepurple'){
 echo "You have removed the codominant red from your creature- it is now homozygous blue!"; 
 }
 if($action == 'bluegreen'){
 echo "You have removed the codominant yellow from your creature- it is now homozygous blue!"; 
 }
 if($action == 'redpurple'){
 echo "You have removed the codominant blue from your creature- it is now homozygous red!"; 
 }
 if($action == 'redorange'){
 echo "You have removed the codominant yellow from your creature- it is now homozygous red!"; 
 }
 if($action == 'yellowgreen'){
 echo "You have removed the codominant blue from your creature- it is now homozygous yellow!"; 
 }
 if($action == 'yelloworange'){
 echo "You have removed the codominant red from your creature- it is now homozygous yellow!"; 
 }
 if($action == 'orangemela'){
 echo "You have removed your creature's blue coloration from its melanism to form a codominant color mix. Your creature now displays heterozygous red and yellow patches!"; 
 }
 if($action == 'greenmela'){
 echo "You have removed your creature's red coloration from its melanism to form a codominant color mix. Your creature now displays heterozygous blue and yellow patches!"; 
 }
   if($action == 'purplemela'){
 echo "You have removed your creature's yellow coloration from its melanism to form a codominant color mix. Your creature now displays heterozygous red and blue patches!"; 
 }
  if($action == 'purpleblue'){
 echo "You have added blue to your creature's red coloration to form a codominant color mix. Your creature now displays heterozygous red and blue patches!"; 
 }
   if($action == 'purplered'){
 echo "You have added red to your creature's red coloration to form a codominant color mix. Your creature now displays heterozygous red and blue patches!"; 
 }
   if($action == 'orangered'){
 echo "You have added red to your creature's yellow to form a heterozygous codominant coloration!"; 
 }
   if($action == 'orangeyellow'){
 echo "You have added yellow to your creature's red to form a heterozygous codominant coloration!"; 
 }
   if($action == 'greenblue'){
 echo "You have added blue to your creature's yellow to form a heterozygous codominant coloration!"; 
 }
   if($action == 'greenyellow'){
 echo "You have added yellow to your creature's blue to form a heterozygous codominant coloration!"; 
 }
 if($action == 'Rb'){
	 echo "Rb";
 }
  if($action == 'rB'){
	 echo "rB";
 }
 ?> 

 </body>

</html>