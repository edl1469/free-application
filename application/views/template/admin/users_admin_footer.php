<!-- users_admin_footer-->
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>


<!-- Javascript for dataTables -->
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>


<script>

    $("#division").change(function () {


        var form_data = {
            division: $('#division').val(),

        }
        $.ajax({

            url: '<?php echo base_url("users_admin/getdivision");?>',
            type: "POST",
            dataType: 'html',
            data: form_data,
            resetForm: true,
            success: function (data) {
                $("#div_results").html(data).show();
                $("#division_results").DataTable({
                    "language": {
                        "search": "Filter:"
                    }
                });
                console.log(data);

            }
        });
    });

    $("#btn_newapp").click(function () {
        $("#new_approver").show();
    });
    $("#btn_delapp").click(function () {
        $("#del_approver").show();
    });

    $("#appdivision").change(function () {


        var form_data = {
            division: $('#appdivision').val(),

        }
        $.ajax({

            url: '<?php echo base_url("approvals_admin/getApprovals");?>',
            type: "POST",
            dataType: 'html',
            data: form_data,
            resetForm: true,
            success: function (data) {
                $("#div_results").html(data).show();
                $("#division_results").DataTable({
                    "language": {
                        "search": "Filter:"
                    }
                });
                console.log(data);

            }
        });
    });
    $("#cnclsearch").click(function(){
       $("#new_approver").hide();
       $("#user_results").hide();

    });
    $("#btn_newapp").click(function () {
        $("#new_approver").show();
        $('#bid').val('');
        $('#bid').focus();
    });
    $("#btn_delapp").click(function () {
        $("#del_approver").show();

    });
    $(".appcheck").click(function () {

        if ($('.appcheck').filter(':checked').length > 0){
            $("#btn_delapp").show();
        }
        else{
            $("#btn_delapp").hide();
        }
    });

    $("#canceldelete").click(function () {
        $(".appcheck").removeAttr('checked');
        location.reload();
    });



    $("#search").click(function (e) {
        e.preventDefault();
        var searchvalue = '';
        if($('input[name=optradio]:checked').val() == 'name')
        {
            searchvalue = 'name';
        }
        else{
            searchvalue = 'id';
        }
        var form_data = {
            search: $('#bid').val(),
            svalue: searchvalue,
        }
        $.ajax({

            url: '<?php echo base_url("approvers_admin/finduser");?>',
            type: "POST",
            dataType: 'html',
            data: form_data,
            resetForm: true,
            success: function (data) {
                $("#user_results").html(data).show();
                console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(data);
  }
        });
    });
    $("#delsearch").click(function () {
        var searchIDs = $("input:checkbox:checked").map(function(){
            return this.value;
        }).toArray();

        var form_data = {
            approverlist: searchIDs,
        }

        $.ajax({

            url: '<?php echo base_url("approvers_admin/deleteuser");?>',
            type: "POST",
            dataType: 'html',
            data: form_data,
            resetForm: true,
            success: function (data) {
                console.log(data);
                console.log(searchIDs);
                location.reload();

            }
        });
    });
    $("#add_app").click(function () {
        var form_data = {
            beachid: $('#beachid').val(),
            division: $('#division').val(),
            email: $('#email').val(),

        }
        $.ajax({

            url: '<?php echo base_url("approvers_admin/approveradd");?>',
            type: "POST",
            dataType: 'html',
            data: form_data,
            resetForm: true,
            success: function (data) {

                location.reload();
            }
        });

    });


</script>

</body>
</html>