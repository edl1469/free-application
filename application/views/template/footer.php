<div class="container">
    <div id="norecords">No records found.</div>
</div>

<div class="row" id="profiles">
    <div class="container">
        <div id="results" class="col-lg-12">


        </div>
    </div>
</div>
<!-- Footer -->
<footer>
    <div class="row navbar-fixed-bottom">
        <div class="col-lg-12" id="doit">
            <p>Copyright &copy; DOIT - CSULB</p>
        </div>
    </div>
    <!-- /.row -->
</footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>


<!-- Javascript for dataTables -->
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>


<script>
    $(document).on('submit', function (e) {
        e.preventDefault();
        if ( $("#details").is(':visible') ){
            $("#details").hide();
        }
        if ($("#inputDept").val() == undefined){
            $("#inputDept").val('');
        }
        if($("#about").is(":visible")){
            $("#about").hide();
        }
        if($("#how").is(":visible")){
            $("#how").hide();
        }


        var form_data = {
            firstname: $('#inputFirst').val(),
            lastname: $('#inputLast').val(),
            department: $("#inputDept").val(),
            keywords: $('#keywords').val(),
            division: $('#inputDiv').val(),

        };


        $.ajax({
            url: '<?php echo base_url("search/search_experts");?>',
            type: "POST",
            dataType: 'html',
            data: form_data,
            resetForm: true,
            async:true,
            cache:false,
            success: function (data) {

                if (data == 'empty'){
                    $("#empty").modal('show');
                    $("#nothin").focus();
                }
                else if (data == 'no data'){
                    $("#no-records").modal('show');
                    $("#records").focus();
                }
                else{
                    
                $("#results").html(data).fadeIn('slow');
                $("#results").get(0).scrollIntoView();
                $("#table-results").DataTable({
                    keys:true,

                    "headerCallback": function( thead, data, start, end, display ) {
                     $("#results").find('h2').html( 'Displaying '+(end-start)+' records' );
                    },

                    

                    "language": {
                        "search": "Filter:"
                    },

                    "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,

                    } ]
                });
                $("#table-results thead").focus( function(){

                });
                
                }
                console.log(data);

            },


        });

        });
 $(window).bind('hashchange', function () {
    
      if (location.hash == null || location.hash == "") {
          
        $("#details").hide();
        $("#results").show();

      }
    
  });



</script>
<script>

    $('#inputDiv').change(function () {

        $.ajax({
            url: '<?php echo base_url("search/get_departments");?>',
            type: "POST",
            dataType: 'html',
            data: {divs: $('#inputDiv').val()},
            success: function (data) {
                $("#deptsdisplay").html(data).show();

                if (data == 'nothing') {

                    console.log('Query with no results');
                }

            },
            error: function (data) {
                alert('NO GOOD');
                console.log(data);
            }
        });
    });

    $("#plus-search").click(function (e) {
        e.preventDefault();
        $("#refined").toggle('slow');
        $("#ref-button").toggleClass('glyphicon-plus').toggleClass('glyphicon-minus');

    });

    $("#resetall").click(function () {
        $("#results").hide('slow');
        $("#inputDept").hide();
        if ( $("#details").is(':visible') ){
            $("#details").hide('slow');
        }
        if ($("#deptsdisplay").is(':visible')){
            $("#deptsdisplay").hide('slow');
        }

    });

    $("#norecordsclose").click(function(){
        $("#resetall").click();
        $("#keywords").focus();
    });


    $("#aboutlink").click(function (e) {
        e.preventDefault();
        $("#about").show();
    });
    $("#close-about").click(function () {

        $("#about").hide();
    });

    $("#howlink").click(function (h) {
        h.preventDefault(h);
        $("#how").toggle();
    });
    $("#close-how").click(function () {

        $("#how").hide();
        $("#how-icon").focus();
    });

    
</script>


</body>

</html>
