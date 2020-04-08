<?php
	session_start();
	require_once "./functions/database_functions.php";
	$conn = db_connect();

	$query = "SELECT * FROM author ORDER BY authorid";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	if(mysqli_num_rows($result) == 0){
		echo "Empty author ! Something wrong! check again";
		exit;
	}

	$title = "List Of authors";
	require "./template/header.php";
?>
<link rel="stylesheet" type="text/css" href="publisher.css">
	<p class="lead"><span style="color: black; font-size:40px;">List of author</p>
	<ul>
	<?php 
		while($row = mysqli_fetch_assoc($result)){
			$count = 0; 
			$query = "SELECT authorid FROM books";
			$result2 = mysqli_query($conn, $query);
			if(!$result2){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}
			while ($autInBook = mysqli_fetch_assoc($result2)){
				if($autInBook['authorid'] == $row['authorid']){
					$count++;
				}
			}
	?>
		<li>
			<span class="badge"><?php echo $count; ?></span>
		    <a href="bookPerAut.php?autid=<?php echo $row['authorid']; ?>"><?php echo $row['author_name']; ?></a>
		</li>
	<?php } ?>
		<li>
			<a href="books.php">List full of books</a>
		</li>
	</ul>
<?php
	mysqli_close($conn);
	require "./template/footer.php";
?>