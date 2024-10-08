<?php
session_start();



?>
<html>
  <head>
<h1>Create New Recipe</h1>    
  </head>
  <body>
    <form method="POST" action="">
      <div>
        <label>Title</label> <br>
        <input name="title" type="text" required />
      </div>
      <br>
      <div>
        <label>Cook Time (In minutes)</label>
        <input name="cooking_time" type="text" required />
      </div>
      <br>
      <div>
        <label>Add image (optional)</label>
        <input name="image" type="file" accept="image/png, image/jpeg" />
      </div>
      <br>
      <div>
        <label>Recipe</label>
        <input name="recipe" type="text" maxLength="250" />
      </div>
      <br>
      <div>
        <label>Instruction</label>
        <input name="instruction" type="text" maxLength="1000" />
      </div>
      <button type="submit">Post</button>
    </form>
  </body>
</html>
