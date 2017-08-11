<body>


<div class="row-fluid">

    <div class=" container box-header">
    <div class="container"><h1>URL Seeding Page.</h1>
        <div class="form-group col-md-6 jumbotron" style="padding:2em;">

        <form method="post" action="dashboard_seed/upload" enctype="multipart/form-data">


            <input type="file" class="col-md-6"  style="margin:2em;" name="csvfile">
            <input type="submit"  class="form-control col-md-6" value="Submit" style="margin:2em;">
        </form></div>
        <?php
        if (isset($_SESSSION['count'])){
     	echo'<div class="clearfix"></div><div class="col-md-6 alert alert-success" style="margin-top:2em;">
     		Total Number of Records Updated: <strong>'.$_SESSSION['count'].'</strong>
        </div>';
    }
    ?>
    </div>
    </div>
    </div>
</body>
