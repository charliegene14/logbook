<?php

require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/database.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/dbPosts.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/dbCategories.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/dbWorks.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/dbTools.php';

class FilteredPosts extends database {

    public ?int $type;
    public ?int $work;
    public ?int $tool;
    public int $postsByPage;
    public int $page;

    private ?string $filtered = null;
    private array $posts;
    private bool $isFiltered = true;
    private int $numberPages;
    private int $numberPosts;
    public ?PDOStatement $queryTypes = null;
    public ?PDOStatement $queryWorks = null;
    public ?PDOStatement $queryTools = null;

    function __construct(?int $type = null, ?int $work = null, ?int $tool = null, ?int $postsByPage = null) {

        if ($postsByPage == null) {
            $postsByPage = 4;
        }

        if ($type == NULL && $work == NULL && $tool == NULL) {
            $this->isFiltered = false;
        }

        elseif ($type != null && $work == null && $tool == null) {
            $this->filtered = 'type';

        } elseif ($type == null && $work != null && $tool == null) {

            $this->filtered = 'work';

        } elseif ($type == null && $work == null && $tool != null) {
            $this->filtered = 'tool';

        } elseif ($type != null && $work != null && $tool == null) {
            $this->filtered = 'type.work';

        } elseif ($type != null && $work == null && $tool != null) {
            $this->filtered = 'type.tool';

        } elseif ($type == null && $work != null && $tool != null) {
            $this->filtered = 'work.tool';

        } else {
            $this->filtered = 'all';
        }
        
        $this->postsByPage = $postsByPage;
        $this->type = $type;
        $this->work = $work;
        $this->tool = $tool;
        $this->setFiltersQueries();
    }

    /**
     * Get all posts filtered if they are, or not.
     */
    public function getPosts(?int $page = null): array {
        $db = $this->dbConnect();
        $dbPosts = new dbPosts();

        $query = $dbPosts->getAll();
        $posts = $query->fetchAll();

        if ($this->isFiltered) {
            $this->posts = $this->filtering($posts);
        } else {
            $this->posts = $posts;
        }

        if ($page == null) {
            return $this->sorting($this->posts);
        } elseif ($page == 0) {
            $page = 1;
        } else {

            $posts = $this->sorting($this->posts);
            $first = ($page - 1) * $this->postsByPage;

            return array_slice($posts, $first, $this->postsByPage);
        }
    }

    private function setFiltersQueries() {

        $db = $this->dbConnect();
        $dbCats = new dbCategories();
        $dbWorks = new dbWorks();
        $dbTools = new dbTools();

        switch ($this->filtered) {

            case 'type':
                $this->queryTypes = $dbCats->getAll();
                $this->queryWorks = $dbWorks->getByType($this->type);
                $this->queryTools = $dbTools->getByType($this->type);
                break;

            case 'tool':
                $this->queryTypes = $dbCats->getByTool($this->tool);
                $this->queryTools = $dbTools->getAll();
                break;

            case 'type.work':
                $this->queryTypes = $dbCats->getByWork($this->work);
                $this->queryWorks = $dbWorks->getByType($this->type);
                $this->queryTools = $dbTools->getByWork($this->work);
                break;

            case 'type.tool':
                $this->queryTypes = $dbCats->getByTool($this->tool);
                $this->queryWorks = $dbWorks->getByTypeTool($this->type, $this->tool);
                $this->queryTools = $dbTools->getByType($this->type);
                break;

            case 'all':
                $this->queryTypes = $dbCats->getByTool($this->tool);
                $this->queryWorks = $dbWorks->getByTypeTool($this->type, $this->tool);
                $this->queryTools = $dbTools->getByWork($this->work);
                break;

            default:
                $this->queryTypes = $dbCats->getAll();
                $this->queryTools = $dbTools->getAll();
                break;
        }
    }

    /**
     * Select posts accomodating filters.
     * Filters: type, work, tool.
     * May contains cloned posts (many-to-many table).
     */
    private function filtering(array $posts): array {
        $newArray = [];

        foreach ($posts as $post) {
           switch ($this->filtered) {

                case 'type':
                    if ($post['Type'] == $this->type) {
                        array_push($newArray, $post);
                    }
                    break;

                case 'work':
                    if ($post['Work'] == $this->work) {
                        array_push($newArray, $post);
                    }
                    break;

                case 'tool':
                    if ($post['idTool'] == $this->tool) {
                        array_push($newArray, $post);
                    }
                    break;

                case 'type.work':
                    if ($post['Type'] == $this->type && $post['Work'] == $this->work) {
                        array_push($newArray, $post);
                    }
                    break;

                case 'type.tool':
                    if ($post['Type'] == $this->type && $post['idTool'] == $this->tool) {
                        array_push($newArray, $post);
                    }
                    break;

                case 'work.tool':
                    if ($post['Work'] == $this->work && $post['idTool'] == $this->tool) {
                        array_push($newArray, $post);
                    }
                    break;

                case 'all':
                    if ($post['Type'] == $this->type && $post['Work'] == $this->work && $post['idTool'] == $this->tool) {
                        array_push($newArray, $post);
                    }
                    break;
            }
        }
        return $newArray;
    }

    /**
     * Delete cloned posts.
     * After filtering.
     */
    private function sorting(array $posts): array {
        $i = 0;
        $newArray = [];

        foreach ($posts as $post) {
            if ($post['idPost'] != $posts[$i-1]['idPost']) {
                array_push($newArray, $post);
            }
            $i++;
        }

        return $newArray;
    }

    public function getNumberPosts(): int {
        return $this->numberPosts = count($this->getPosts());
    }

    public function getNumberPages(): int {
        return $this->numberPages = ceil($this->getNumberPosts() / $this->postsByPage);
    }

    /**
     * Return html pagination template.
     */
    public function getPagination(?int $page = 1) {
        for($i=1; $i <= $this->numberPages; $i++)
		{
			if ($i == $page) {
			    echo ' <strong> '.$i.' </strong> ';
			} else {
				echo ' <a href="index.php?view=posts';
				echo !empty($_GET['type']) || !empty($_POST['type']) ? '&amp;type='.$_POST['type'] : false;
                echo !empty($_GET['work']) || !empty($_POST['work']) ? '&amp;type='.$_POST['work'] : false;
                echo !empty($_GET['tool']) || !empty($_POST['tool']) ? '&amp;type='.$_POST['tool'] : false;
				echo '&amp;pg='.$i.'"> '.$i.' </a>';
			}
		}
    }
}