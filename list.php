<?php
include("document.php");

class BookList
{
	private $path;
	private $fileArray;
	public function __construct($path)
	{
		$this->path = $path;
		$this->makeList();
	}
	
	public function getFileArray() { return $this->fileArray; }
	
	public function makeList()
	{
		$files = scandir($this->path);
		$this->fileArray = array();
		
		for($i=0; $i<count($files); ++$i)
			if(stristr($files[$i], ".pdf"))
				array_push($this->fileArray, $files[$i]);

		//return $fileArray;
	}
	
	public function saveList()
	{
		removeOlds();
		addNews();
	}
	
	private function removeOlds()
	{
		$conf = new Config();
		$conn = $conf->getConnection();
		
		$sql = "SELECT docname from books";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			# code...
			while ($row = $result->fetch_assoc()) {
				echo  $row['docname'];
				if (!in_array($row["docname"], $this->fileArray))
					echo  $row['docname'];
						
					//$conn->query("DELETE FROM books WHERE docname=$row['docname']");
			}
		}
	}
	
	public function addNews()
	{
		//echo $this->path;
		print_r($this->fileArray);
		foreach ($this->fileArray as $file) {
			# code...
			//echo 'girdi';
			$title = explode(".", $file)[0];
			//$pgnum = $this->totalNumber();
			//echo $file.'<br>';
			
			$book = new Document($this->path,$file, $title);
			
			echo "<br>";
			echo $book->getPageNum();
			
			$book->save();
		}
		
		//$book = new Document($this->path, "can.pdf", "can");
		$book->save();
	}
	
	
}

$list = new BookList("../../");
//$files = $list->makeList(".");
//echo"<pre>";print_r($list->getFileArray());echo"</pre>";
$list->addNews();

?>