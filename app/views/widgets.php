<section id="widgetsPage">

<div class="wrap">

<div id="icon-themes" class="icon32 icon32-posts-post"><br></div>
<h2>My Widgets <a href="admin.php?page=notelr-add-widget" class="add-new-h2">Add New</a></h2>
<br/>

<table class="widefat">
	<thead>
	    <tr>
	        <th>Keywords</th>
	        <th>Type</th>       
	        <th>Widget ID</th>
	        <th></th>
	        <th></th>
	    </tr>
	</thead>
	<tfoot>
	    <tr>
	    	<th>Keywords</th>
	        <th>Type</th>       
	        <th>Widget ID</th>
	        <th></th>
	        <th></th>
	    </tr>
	</tfoot>
	<tbody>
	<?php
	if (empty($this->widgets)):
	    ?>
	    <p>No widgets found!</p>
	<?php
	else:
	    ?>
	    <?php
	    foreach ($this->widgets as $widget):
	        ?>
	        <tr>
	        	<td><b><?php echo (empty($widget['keywords'])? $widget['location']:$widget['keywords']);?></b></td>
	        	<td><?php echo $widget['type'];?></td>
				<td><?php echo $widget['custom_hash'];?></td>
				<td><a href="admin.php?page=notelr-edit-widget&id=<?php echo $widget['id']; ?>&type=<?php echo $widget['type'];?>" class="button">Edit</a></td>
				<td><a class="delete-widget" href="admin.php?page=notelr-delete-widget&id=<?php echo $widget['id']; ?>&type=<?php echo $widget['type'];?>">Delete</a></td>
	        </tr>
	    <?php
	    endforeach;
	endif;
	?>
	</tbody>
</table>

</div>
</section>
<script type="text/javascript">
    jQuery(".delete-widget").click(function(e){
        var ok=confirm("Are you sure you want to delete this widget?");
        if(!ok){
            return false;
        }
    });
</script>
