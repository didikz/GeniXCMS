<?php
/**
* GeniXCMS - Content Management System
* 
* PHP Based Content Management System and Framework
*
* @package GeniXCMS
* @since 0.0.1 build date 20150202
* @version 0.0.1
* @link https://github.com/semplon/GeniXCMS
* @author Puguh Wijayanto (www.metalgenix.com)
* @copyright 2014-2015 Puguh Wijayanto
* @license http://www.opensource.org/licenses/mit-license.php MIT
*
*/
    if (isset($data['alertgreen'])) {
        # code...
        echo "<div class=\"alert alert-success\" >
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">
            <span aria-hidden=\"true\">&times;</span>
            <span class=\"sr-only\">Close</span>
        </button>";
        foreach ($data['alertgreen'] as $alert) {
            # code...
            echo "$alert\n";
        }
        echo "</div>";
    }
    if (isset($data['alertred'])) {
        # code...
        echo "<div class=\"alert alert-danger\" >
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">
            <span aria-hidden=\"true\">&times;</span>
            <span class=\"sr-only\">Close</span>
        </button>";
        foreach ($data['alertred'] as $alert) {
            # code...
            echo "$alert\n";
        }
        echo "</div>";
    }
?>
<div class="row">
    <div class="col-md-12">
        <h1><i class="fa fa-file-text-o"></i> Posts <a href="index.php?page=posts&act=add" class="btn btn-primary pull-right">Add New</a></h1>
        <hr />
    </div>
    <div class="col-sm-12">
    <div class="table-responsive">
    <table class="table table-hover">
        <form action="" method="post">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Status</th>
                <th>Edit/Delete</th>
                <th>All <input type="checkbox" id="selectall"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                //print_r($data);
                if($data['num'] > 0){
                    foreach ($data['posts'] as $p) {
                        # code...
                        //echo $p->id;
                        if($p->status == '0'){
                            $status = "UnPublished";
                        }else{
                            $status = "Published";
                        }
                        echo "
                        <tr>
                            <td>{$p->id}</td>
                            <td><a href=\"".Url::post($p->id)."\" target=\"_new\">{$p->title}</a></td>
                            <td>".Categories::name($p->cat)."</td>
                            <td>{$p->date}</td>
                            <td>{$status}</td>
                            <td>
                                <a href=\"index.php?page=posts&act=edit&id={$p->id}&token=".TOKEN."\" class=\"label label-success\">Edit</a> 
                                <a href=\"index.php?page=posts&act=del&id={$p->id}&token=".TOKEN."\" class=\"label label-danger\" 
                                onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a>
                            </td>
                            <td>
                                <input type=\"checkbox\" name=\"post_id[]\" value=\"{$p->id}\" id=\"select\">
                            </td>
                        </tr>
                        ";
                    }
                }else{
                    echo "
                    <tr>
                        <td>No Post Found
                        </td>
                    </tr>";
                }
            ?>
            
        </tbody>
        <tfoot>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Status</th>
            <th>
            <select name="action" class="form-control">
                <option value="publish">Publish</option>
                <option value="unpublish">UnPublish</option>
                <option value="delete">Delete</option>
            </select>
            <input type="hidden" name="token" value="<?=TOKEN;?>">
            </th>
            <th>
                <button type="submit" name="doaction" class="btn btn-danger">
                    Submit
                </button>
            </th>
        </tfoot>
        </form>
    </table>
    </div>
    </div>
</div>