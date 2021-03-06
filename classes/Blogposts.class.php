<?php
//Tilda Källström 2021 Webbutveckling 2 Mittuniversitetet
class Blogposts
{
    //properties
    private $db;
    private $title;
    private $content;


    //metoder
    function __construct()
    {
        //connect to db
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //plocka fram alla blogposts, visa den nyaste högst upp
    public function getBlogposts(): array
    {
        $sql = "SELECT * FROM blogposts JOIN user where user.username = blogposts.author ORDER BY created DESC;";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //plocka fram alla blogposts från specifik skapare, visa den nyaste högst upp
    public function getBlogpostsFromAuthor(): array
    {
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM blogposts JOIN user WHERE user.username ='$username' ORDER BY created DESC;";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    //plocka fram alla blogposts från specifik skapare, visa den nyaste högst upp
    public function getBlogpostsFromThisAuthor(): array
    {
        $id = $_GET['id'];
        $sql = "SELECT * FROM blogposts JOIN user on blogposts.authorid=user.id WHERE blogposts.authorid = $id ORDER BY created DESC;";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    //hämta blogpost via postid
    public function getBlogpostFromId($postid)
    {
        $postid = intval($postid);
        $sql = "SELECT * FROM blogposts JOIN user WHERE postid=$postid AND user.username = blogposts.author;";
        $result = $this->db->query($sql);
        $row = mysqli_fetch_array($result);
        return $row;
    }
    //metod som ej används
    /* public function getTitleFromId($id) {
        $id = intval($id);
        $sql = "SELECT title FROM blogposts WHERE postid=$postid";
        $result = $this->db->query($sql);
        $row = mysqli_fetch_array($result);
        return $row['title'];
    } */
    //skapa blogpost
    public function addBlogpost($author, $authorid, $title, $content, $img)
    {
        //Control if correct values
        if (!$this->setTitle($title)) {
            return false;
        }
        if (!$this->setContent($content)) {
            return false;
        }
       

            //Kontrollerar att uppladdad bild är av rätt typ (JPEG, png) 
            if ((($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] ==
                "image/png") && ($_FILES["file"]["size"] < 200000))) {
                $img = $_FILES["image"]["name"];
                if ($img) {
                    // ändra storlek på bild
                    $maxDimW = 500;
                    $maxDimH = 500;
                    list($width, $height) = getimagesize($_FILES['image']['tmp_name']);
                    if ($width > $maxDimW || $height > $maxDimH) {
                       $target_filename = $_FILES['image']['tmp_name'];
                        $fn = $_FILES['image']['tmp_name'];
                        $size = getimagesize($fn);
                        $ratio = $size[0] / $size[1]; // width/height
                        if ($ratio > 1) {
                            $width = $maxDimW;
                            $height = $maxDimH / $ratio;
                        } else {
                            $width = $maxDimW * $ratio;
                            $height = $maxDimH;
                        }
                        $src = imagecreatefromstring(file_get_contents($fn));
                        $dst = imagecreatetruecolor($width, $height);
                        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                        imagejpeg($dst, $target_filename); 

                    }        //Flyttar filen till rätt katalog      
                    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
                }
            }
        
        // om filen är av rätt typ, läggs den in i db, annars läggs posten in utan att kolumnen för img fylls
        if ((($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] ==
            "image/png"))) {
            $sql = "INSERT INTO blogposts(author, authorid, title, content, img)VALUES('$author', $authorid, '" . $this->title . "', '" . $this->content . "', '$img');";
            $result = $this->db->query($sql);
            return $result;
        } else {
            $sql2 = "INSERT INTO blogposts(author, authorid, title, content)VALUES('$author', $authorid, '" . $this->title . "', '" . $this->content . "');";
            $result2 = $this->db->query($sql2);
            return $result2;
        }
    }
//radera bloggpost
    public function deleteBlogpost($postid)
    {
        $postid = intval($postid);
        // kollar om det finns en bild i bloggposten
        $sql = "SELECT img FROM blogposts WHERE postid = $postid;";
        $result = $this->db->query($sql);
        $row = mysqli_fetch_array($result);
        $img = $row['img'];
        $target = "uploads/" . $img;
//om det finns bild, raderas den från filmappen
        if ($img != "") {
            unlink($target);
            $sql2 = "DELETE FROM blogposts WHERE postid=$postid;";
            return $this->db->query($sql2);
        } else {
            // annars raderas bara själva posten från DB
            $sql1 = "DELETE FROM blogposts WHERE postid=$postid;";
            return $this->db->query($sql1);
        }
    }
//uppdatera post
    public function updateBlogpost($title, $content, $postid)
    {
        $postid = intval($postid);
        if (!$this->setTitle($title)) {
            return false;
        }
        if (!$this->setContent($content)) {
            return false;
        }
            $sql = "UPDATE blogposts SET title='" . $this->title . "', content='" . $this->content . "' WHERE postid=$postid;";
            $result = $this->db->query($sql);
             return $result;
    
        
    }
//set title
    public function setTitle($title)
    {
        if (filter_var($title)) {
           $title = strip_tags(html_entity_decode($title), '<p><a><br><i><b><strong><em>');
            $this->title = $this->db->real_escape_string($title);
            //$this->title = $this->db->real_escape_string($title);
            return true;
        } else {
            return false;
        }
    }
    
//set content
    public function setContent($content)
    {
        if (filter_var($content)) {
            $content = strip_tags(html_entity_decode($content), '<p><li><ol><a><br><i><b><strong><em>');

            $this->content = $this->db->real_escape_string($content);
            return true;
        } else {
            return false;
        }
    }
//hämta de senaste fem posterna
    public function getFiveBlogposts(): array
    {
        $sql = "SELECT * FROM blogposts JOIN user where user.username = blogposts.author ORDER BY created DESC LIMIT 5;";
        $result = $this->db->query($sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
//hämta bloggposter från de användare man följer
    public function getFollowedPosts(): array
    {
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM user JOIN (SELECT * FROM blogposts JOIN following ON following.followerid = blogposts.authorid) followerposts ON followerposts.followerid = user.id WHERE followerposts.username = '$username' ORDER BY CREATED DESC;";

        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
//räkna antal kommentarer på denna blogpost
    public function countComments($postid) {
        $postid = intval($postid);
        $sql = "SELECT COUNT(*) FROM comments WHERE postid=$postid;";
        $result = $this->db->query($sql);
      return $result;
    }
}
