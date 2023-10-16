<?php require_once '/home/vagrant/code/wordpresstutorial/wordpress/wp-admin/admin.php'; ?>

<!doctype html>
  <!--Copy code form jQuery handbook-->
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
      <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

      <!-- jQuery Modal-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

      <title>Edit Categories</title>

      <script>
        // jQuery accordion script
        $( function() {
          $("#accordion").accordion();
        } );
      </script>

      <!--Beginning of script getting all categories and posts-->
      <script>

      <?php
        // Category name global variable
        global $allCategories, $categoryID;
        $allCategories = get_categories(array(
          "orderby" => "name"
        ));
        // Establishes category number when displaying post categories
        $categoryID = array();

        foreach ($allCategories as $category) {
          array_push($categoryID, $category->cat_ID);
        }
      ?>

        // Calls other functions for HTML body
        function start() {
          getMyCatsAndPosts();
        }
        
        // Beginning of getMyCatsAndPosts()
        function getMyCatsAndPosts() {

          // Gets available categories and puts into a availableCategories variable
          const availableCategories = [

            <?php 
              $num = 0;

              foreach ($allCategories as $category) {
                echo '"Category Name: '.$category->name.' '; 
                echo '<p><a href=\'#ex'.$categoryID[$num].'\' rel=\'modal:open\'>Edit Category</a></p>",';
                $num += 1;
              } 
            ?> 

          ];

          // Gets available posts from each category and displays them
          const availablePosts = [];

          <?php for ($i = 0; $i < count($categoryID); $i++) { ?>
            availablePosts.push(
              [
              <?php 
                $allposts = get_posts(array(
                  "numberposts" => 11,
                  "category" => $categoryID[$i],
                  "post_type" => "post",
                  "post_status" => "publish"
                ));

                foreach ($allposts as $posts => $title) {
                  echo '" Post Name: '.$title->post_title.'",';
                }
              ?>
              ]
            );
          <?php } ?>

          // Gets the available categories and posts and outputs it in the accordion
          <?php for ($i = 1; $i < count($categoryID) + 1; $i++) { ?> 
            document.getElementById("cat<?php echo $i; ?>").innerHTML = availableCategories[<?php echo $i - 1; ?>];
            document.getElementById("post<?php echo $i; ?>").innerHTML = availablePosts[<?php echo $i - 1; ?>];
          <?php } ?>

        } // End of getMyCatsAndPosts()

        // Validates category name change form
        function validation(formID) {
          let theInput = document.forms[formID]["new_name"].value;
          
          switch (theInput) {

            // Prevents form from submitting if new name contains nothing
            case "" :
              alert("New category name must be filled out");
              event.preventDefault();
              return false;
              break;

            // Prevents form from submitting if new name contains any numbers
            case theInput.match(/[0-9]/)?.input:
              alert("New category name must not contain numbers");
              event.preventDefault();
              return false;
              break;

            // Prevents form from submitting if new name contains non alphanumeric characters
            case theInput.match(/[’/`~!#*$@_%+=,^&(){}[\]|;:”<>?\\]/)?.input:
              alert("New category name must not contain invalid characters");
              event.preventDefault();
              return false;
              break;

          }

          // Reloads page after it form is submitted
          location.reload(true);
          
        } // End of validation()

      </script>
      <!--End of script getting all categories and posts-->

      <?php
        /**
         * First if statement checks if form is not empty and allows user to change category name in the database
         * Second if statement gets category names after form is submitted
         */

        // Gets category name and id and changes it when user inputs new name
        // POST CATEGORY
        if (!empty($_POST)) {
          $cat_id = $_POST["cat_id"];
          $new_name = $_POST["new_name"];  

          if ($cat_id && $new_name) { 
              $category = get_category($cat_id);
              $category->cat_name = $new_name;
              $new_arr = array(
                "cat_name" => $new_name,
                "cat_ID"=> $cat_id
              );
              
              $resp = wp_update_category($new_arr);
          }

        }

      // End of PHP that updates categories 
      ?>

    </head>
    
    <body onload="start()">
      <h1>Edit Categories</h1>
     
      <div class="widget">
        <div class="parent">
          <div class="inline-block-child">
            <!--Loop create multiple forms-->
            <?php
                /** 
                 * Loops through $categories and outputs all category names.
                 * If $category is the edit link next to category name, option is preselected.
                */
              foreach ($allCategories as $cat) { 
                $selected = $cat->cat_ID;
            ?>
            
                <div id="ex<?php echo $selected; ?>" class="modal">
                  <h3>Edit Categories</h3>
    
                    <!-- Form that posts category names and allows user to select the categories by
                    looping through $categories array. Allows user to change category name after inputting
                    new name and clicking the save button.-->
                    <form name="myForm<?php echo $selected; ?>" method="post" action="" onsubmit="validation('myForm<?php echo $selected; ?>')" id="myForm<?php echo $selected; ?>">
                      <label for="cat_id">Selected Category:</label>

                      <!--Gets category names and outputs them as options-->
                      <select name="cat_id" id="cat_id"> 
                        <?php foreach ($allCategories as $category) {
                          if ($category->cat_ID == $selected) { ?>
                            <option selected value="<?php echo $category->cat_ID; ?>"><?php echo $category->name;?> </option>
                        <?php  
                          } 

                          if ($category->cat_ID != $selected) {
                        ?>
                            <option value="<?php echo $category->cat_ID; ?>"><?php echo $category->name;?> </option>
                        <?php } 
                        } // End of foreach loop ?>
                      </select> 

                      <br>
                      <label for="new_name">New Category Name:</label>
                      <input type="text" name="new_name" id="new_name">
                      <input type="submit" class="button" value="Save">
                      <br>
                      <a href="#" rel="modal:close">Close</a> <!--Close Modal-->
                    </form>

                </div> <!-- End of modal -->
            <?php 
              } // End of loop 
            ?>

          </div> <!--End of inline-block-child-->
        </div> <!--End of parent-->
      </div> <!--End of widget-->

      <?php 
      // Creates accordion and outputs every category and post names
        echo '<div id="accordion">';
          for ($i = 1; $i < count($categoryID) + 1; $i++) { 
            echo 
              '
              <div>
                <h3><span id=\'cat'.$i.'\'></span></h3>
              </div>

              <div>
                <p>
                  <span id=\'post'.$i.'\'></span> 
                </p>
              </div>'
            ;
          }
        echo '</div>';
      ?>

    </body>

  </html>
