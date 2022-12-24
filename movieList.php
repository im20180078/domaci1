<?php
    include "inc/header.php";

    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
        exit();
    }
?>

<br/>
<div class="container">
    <div class="row">
        <div class="col-6">
            <h2 class="text-info">Movie List</h2>
        </div>
        <div class="col-3 offset-3">
            <a id="btn-add-new" class="btn btn-info form-control text-white"> Add new movie</a>
        </div>
        <div class="col-12 border p-3">
            <table id="DT_load" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Language</th>
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="container">
    <div id="table-manager" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title"></h2>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div id="edit-content">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name"><br>
                            <input type="text" class="form-control" id="language" name="language" placeholder="Language"><br>                            
                            <input type="text" class="form-control" id="year" name="year" placeholder="Year"><br>
                            <input type="number" class="form-control" id="runTime" name="runTime" placeholder="Running_time"><br>

                            <select class="browser-default custom-select" id="select" name="select">
                                <option value="" disabled selected>Choose category</option>
                                <option value="1">Classic</option>
                                <option value="3">Science fiction</option>
                                <option value="5">Drama</option>
                                <option value="6">Comedy</option>
                            </select>
                        </div>
                    </form>

                    <div id="show-content" style="display:none;">
                    <h3>Year</h3>
                    <div id="year-view"></div>
                    <hr>
                    <h3>Running time</h3>
                    <div id="runTime-view"></div>
                    <hr>
                    <h3>Category</h3>
                    <div id="category-view"></div>
                    </div>
                    </div>

                    <div class="modal-footer">
                        <input type="button" class="btn btn-secondary" id="btn-close" data-dismiss="modal" value="Close">
                        <input type="button" class="btn btn-primary" id="btn-manage" onclick="manageData('addNew')" value="Save">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include "inc/footer.php";
?>
                    