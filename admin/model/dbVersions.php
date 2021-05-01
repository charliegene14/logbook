<?php
require_once 'model/database.php';

class dbVersions extends database
{
    public function getVersion($idVersion)
    {
        $DB = $this->dbConnect();
        $QUERY = $DB->prepare('SELECT * FROM projects_versions pv
                                LEFT JOIN projects p
                                ON pv.idProject = p.idProject
                                WHERE pv.idVersion = ?');

        if ($this->dbExist($QUERY, $idVersion))
        {
            $QUERY->execute(array($idVersion));
            return $QUERY;
        }
        else
        {
            throw new Exception('Oops, version introuvable.');
        }
    }

    public function getVersions($idProject)
    {
        $DB = $this->dbConnect();
   
        $CHECK = $DB->prepare('SELECT * FROM projects WHERE idProject = ?');
        $QUERY = $DB->prepare('SELECT * FROM projects_versions WHERE idProject = ? ORDER BY dateVersion DESC');

        if ($this->dbExist($CHECK, $idProject))
        {
            $QUERY->execute(array($idProject));
            return $QUERY;
        }
        else
        {
            throw new Exception('Oops, projet introuvable.');
        }
    }

        public function insert($idProject, $date, $version, $changelog)
        {
            $DB = $this->dbConnect();
            $QUERY = $DB->prepare('INSERT INTO projects_versions (idVersion, idProject, dateVersion, theVersion, changeLog)
            VALUES (NULL, ?, ?, ?, ?)');
            
            $QUERY->execute(array($idProject, $date, $version, $changelog));
        }

        public function update($idVersion, $date, $version, $changelog)
        {
            $DB = $this->dbConnect();
            $CHECKID = $DB->prepare('SELECT * FROM projects_versions WHERE idVersion = ?');
    
            $QUERY = $DB->prepare('UPDATE projects_versions
                                    SET
                                    dateVersion = ?,
                                    theVersion = ?,
                                    changeLog = ?
                                    WHERE idVersion = ?');
    
            if ($this->dbExist($CHECKID, $idVersion))
            {
                $QUERY->execute(array($date, $version, $changelog, $idVersion));
            }
            else
            {
                throw new Exception('Oops, projet introuvable.');
            }
        }

        public function delete($idVersion)
        {
            $DB = $this->dbConnect();
            $CHECKID = $DB->prepare('SELECT * FROM projects_versions WHERE idVersion = ?');
            $QUERY = $DB->prepare('DELETE FROM projects_versions WHERE idVersion = ?');
    
    
            if ($this->dbExist($CHECKID, $idVersion))
            {
                $QUERY->execute(array($idVersion));
            }
            else
            {
                throw new Exception('Oops, projet introuvable.');
            }
        }
}