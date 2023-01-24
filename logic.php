<?php

    // Don't display server errors 
    // ini_set("display_errors", "off");

    // Initialize a database connection
    $conn = mysqli_connect("localhost", "root", "", "blogphp");

    // Destroy if not possible to create a connection
    if(!$conn){
        echo "<h3 class='container bg-dark p-3 text-center text-warning rounded-lg mt-5'>Not able to establish Database Connection<h3>";
    }

    // Get data to display on index page
    $sql = "SELECT * FROM blog_data";
    $query = mysqli_query($conn, $sql);

    // Create a new post
    if(isset($_POST['new_post'])){
        $title = $_POST['title'];
      
        $content = $_POST['content'];
        $stmt =  $conn->prepare("INSERT INTO blog_data(title, content) VALUES(?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        // echo $sql;

        header("Location: index.php?info=added");
        exit();
    }

    // Get post data based on id
    if(isset($_REQUEST['id'])){
      
        $id = $_REQUEST['id'];
        $stmt = $conn->prepare("SELECT * FROM blog_data WHERE id = ?");
        $stmt->bind_param("i",$id); 
        $stmt->execute();
        $query = $stmt->get_result();
    }

    // Delete a post
    if(isset($_REQUEST['delete'])){
        $id = $_REQUEST['id'];

        $stmt = $conn->prepare("DELETE FROM blog_data WHERE id = ?");
        // $stmt->bind_param("i",$id);
        $stmt->bind_param("i", $id);

        if(! $stmt->execute()){
            echo 'Value Error';
           }
        
        header("Location: index.php");
        exit();
    }

    // Update a post
    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $conn->prepare("UPDATE blog_data SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content,$id);
        // mysqli_query($conn, $sql);
       if(! $stmt->execute()){
        echo 'Value Error';
       }
        // mysqli_query($conn, $sql);

        header("Location: index.php");
        exit();
    }

?>
