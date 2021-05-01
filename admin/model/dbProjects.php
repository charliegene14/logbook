<?php

require_once 'model/database.php';

class dbProjects extends database
{
	public function getCount()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT COUNT(idProject) AS total FROM projects');
		$COUNT = $QUERY->fetch()['total'];
		return $COUNT;
	}

	public function getAll()
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->query('SELECT * FROM projects p
							LEFT JOIN category_post cp
							ON p.typeCat = cp.Type');
		return $QUERY;
    }

	public function getProject($idProject)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT * FROM projects p
								LEFT JOIN category_post cp
								ON p.typeCat = cp.Type
								WHERE idProject = ?');
		
		if ($this->dbExist($QUERY, $idProject))
		{
			$QUERY->execute(array($idProject));

			while ($data = $QUERY->fetch())
			{
				$array[0] = $data;
			}
			return $array[0];
		}
		else
		{
			throw new Exception('Oops, projet introuvable.');
		}
    }

    public function getNumber($param)
	{
		$DB = $this->dbConnect();

		if ($param == NULL)
		{
			$QUERY = $DB->query('SELECT COUNT(idProject) AS number FROM projects');
		}
		elseif ($param == 'nextID')
		{
			$QUERY = $DB->query('SELECT COUNT(idProject)+1 AS number FROM projects');
		}

		$NUMBER = $QUERY->fetch()['number'];
		return $NUMBER;
    }
    
    public function delete($id)
    {
        $DB = $this->dbConnect();
        $CHECKID = $DB->prepare('SELECT * FROM projects WHERE idProject = ?');
        $CHECKVERSION = $DB->prepare('SELECT * FROM projects_versions WHERE idProject = ?');

		$QUERY = $DB->prepare('DELETE FROM projects WHERE idProject = ?');


		if ($this->dbExist($CHECKID, $id))
		{
            if ($this->dbExist($CHECKVERSION, $id))
            {
                throw new Exception('Impossible de supprimer, des versions sont liées.');
            }
            else
            {
                $QUERY->execute(array($id));
            }
		}
		else
		{
			throw new Exception('Oops, projet introuvable.');
		}
    }

    public function update($id, $typeCat, $title, $kind, $platform, $date, $preview, $desc)
    {
        $DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM projects WHERE idProject = ?');

		$QUERY = $DB->prepare('UPDATE projects
								SET
                                typeCat = ?,
                                titleProject = ?,
                                kindProject = ?,
                                platformProject = ?,
                                dateProject = ?,
                                previewProject = ?,
                                descProject = ?
								WHERE idProject = ?');

		if ($this->dbExist($CHECKID, $id))
		{
            if ($typeCat == 'NULL')
            {
                $QUERY->execute(array(NULL, $title, $kind, $platform, $date, $preview, $desc, $id));
            }
            else
            {
                $QUERY->execute(array($typeCat, $title, $kind, $platform, $date, $preview, $desc, $id));
            }
        }
        else
        {
            throw new Exception('Oops, projet introuvable.');
        }
    }
    
    public function insert($id, $typeCat, $title, $kind, $platform, $date, $preview, $desc)
    {
        $DB = $this->dbConnect();
		$QUERY = $DB->prepare('INSERT INTO projects (idProject, typeCat, titleProject, kindProject, platformProject, dateProject, previewProject, descProject)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
		
		if ($typeCat == 'NULL')
		{
			$QUERY->execute(array($id, NULL, $title, $kind, $platform, $date, $preview, $desc));
		}
		else
		{
			$QUERY->execute(array($id, $typeCat, $title, $kind, $platform, $date, $preview, $desc));
		}
    }

	public function getLastVersion($idProject)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('SELECT * FROM projects_versions
								WHERE theVersion =
									(SELECT MAX(theVersion) FROM projects_versions
									WHERE idProject = ?)');

		if ($this->dbExist($QUERY, $idProject))
		{
			$QUERY->execute(array($idProject));
			while ($data = $QUERY->fetch())
			{
				$array[0] = $data;
			}
			return $array[0];
		}
		else
		{
			return false;
		}
	}

	public function getFirstPost($idProject)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('SELECT * FROM post
								 WHERE datePost =
										(SELECT MIN(datePost) FROM post p
											LEFT JOIN projects prj
											ON p.Type = prj.typeCat
										 	WHERE prj.idProject = ?)');

		if ($this->dbExist($QUERY, $idProject))
		{
			$QUERY->execute(array($idProject));
			while ($data = $QUERY->fetch())
			{
				$array[0] = $data;
			}
			return $array[0];
		}
		else
		{
			return false;
		}
	}

	public function getLastPost($idProject)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('SELECT * FROM post
								 WHERE datePost =
										(SELECT MAX(datePost) FROM post p
											LEFT JOIN projects prj
											ON p.Type = prj.typeCat
										 	WHERE prj.idProject = ?)');

		if ($this->dbExist($QUERY, $idProject))
		{
			$QUERY->execute(array($idProject));
			while ($data = $QUERY->fetch())
			{
				$array[0] = $data;
			}
			return $array[0];
		}
		else
		{
			return false;
		}
	}
}