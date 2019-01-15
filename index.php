<?php 
error_reporting(-1);
require_once('db.php');

if(!empty($_GET['link'])){
	$sql = "SELECT * FROM links WHERE url = :url";

	$query = $pdo->prepare($sql);
	$query->bindValue(':url', $_GET['link'], PDO::PARAM_STR);
	$query->execute();
	$result = $query->fetchAll();
	
	if(!empty($result)){
		header("Location: ". $result[0]['full_url']);
	}
}

?>

<form action="sokrati.php" method="get">
	<p>Сократить ссылку</p>
	<p class="sokrat-link"></p>
	<textarea rows="10" cols="45" class="text" name="text"></textarea>
	<!--<p><input type="submit"></p>-->
</form>

<button class="submit">Сократить</button>

<script>
	var submit = document.querySelector('.submit');
	var text = document.querySelector('.text');
	var sokratLink = document.querySelector('.sokrat-link');
	
	submit.addEventListener('click', function(){
		xmlhttp=new XMLHttpRequest();
							
		xmlhttp.onreadystatechange=function() {
		
			if (this.readyState==4 && this.status==200) {
				sokratLink.innerHTML = 'Ваша ссылка: ' + this.responseText + '<a href="'+this.responseText+'" target="_blank"> Перейти</a>'; 
			}
		}
		xmlhttp.open("GET","sokrati.php?text="+text.value,true);
		xmlhttp.send();
	});
	
</script>
