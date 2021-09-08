<?php 

class UploadsPage
{
	public function numberOfImg($idPage)
	{
		$numberOfImg = count(glob("../public/img/pages/$idPage-*"));
		return $numberOfImg;
	}

	public function uploadImg($idPage)
	{
		$targetDir = '../public/img/pages/';

		for ($i=0; $i<count($_FILES['img']['name']); $i++)
		{
			$nb = count(glob($targetDir . "$idPage-*"));

			$oldName = explode('.', $_FILES['img']['name'][$i]);
			$newName = $idPage.'-'.$nb.'.'.end($oldName);

			$targetFile = $targetDir . $newName;
			move_uploaded_file($_FILES['img']['tmp_name'][$i], $targetFile);
		}
	}
}

class UploadsPost
{
	public function numberOfImg($idPost)
	{
		$numberOfImg = count(glob("../public/img/posts/$idPost-*"));
		return $numberOfImg;
	}

	public function uploadImg($idPost)
	{
		$targetDir = '../public/img/posts/';

		for ($i=0; $i<count($_FILES['img']['name']); $i++)
		{
			$nb = count(glob($targetDir . "$idPost-*"));

			$oldName = explode('.', $_FILES['img']['name'][$i]);
			$newName = $idPost.'-'.$nb.'.'.end($oldName);

			$targetFile = $targetDir . $newName;
			move_uploaded_file($_FILES['img']['tmp_name'][$i], $targetFile);
		}
	}
}

class UploadsProject
{
	public function uploadIcon($idProject)
	{
		$targetDir = '../public/img/projects/';
		$oldName = explode('.', $_FILES['icon']['name']);
		$newName = $idProject.'.'.end($oldName);
		
		$targetFile = $targetDir . $newName;

		move_uploaded_file($_FILES['icon']['tmp_name'], $targetFile);
	}

	public function uploadVersion($theVersion, $titleProject)
	{
		$targetDir = '../public/files/'.$titleProject.'/versions/';
		$oldName = explode('.', $_FILES['zip']['name']);
		$newName = $theVersion.'.'.end($oldName);
		
		$targetFile = $targetDir . $newName;

		if (!is_dir($targetDir))
		{
			mkdir('../public/files/'.$titleProject.'');
			mkdir('../public/files/'.$titleProject.'/versions');
		}

		move_uploaded_file($_FILES['zip']['tmp_name'], $targetFile);
	}
}

class UploadsTools
{
	public function uploadIcon($idTool)
	{
		$targetDir = '../public/img/tools/';
		$oldName = explode('.', $_FILES['iconTool']['name']);
		$newName = $idTool.'.'.end($oldName);
		
		$targetFile = $targetDir . $newName;

		move_uploaded_file($_FILES['iconTool']['tmp_name'], $targetFile);
	}
}