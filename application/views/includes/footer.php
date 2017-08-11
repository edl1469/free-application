</div> <!-- wrapper ends -->

</div> <!-- #hld ends -->
<script>
    
    $( document ).ready(function() {
    $("#edit_profile").focus();

    // check initial state of search buttons and show check boxes
    if ($("#srch").hasClass("btn-success")){
        $("#srchicon").removeClass('icon-check-empty');
        $("#srchicon").addClass('icon-check');
    }
    if ($("#unsrch").hasClass("btn-success")){
        $("#unsrchicon").removeClass('icon-check-empty');
        $("#unsrchicon").addClass('icon-check');
    }
    });
</script>
<script>

    
    $("#edit_profile").click(function () {
        setTimeout(function(){
        $('#editmode').focus();
        },200);
        $("#profile_btn").toggle();
        $("#cancel_btn").toggle();
        $(".hint").toggle();
        $("#change-content").click();
        $("input,select").removeClass("init-hide");
        $("#displayimage").removeClass("init-hide");
        $(".showtext").hide();
        $("#change-content").click();
        $("#edit_profile").hide();
        $("#editmode").show();
        $("#editmode").attr("aria-live","polite");
        $("#expert-title").focus();
        $("#options").show();
    });

    $("#cancel_btn").click(function () {
        $("#profile input").attr("disabled", true);
        $("#profile_btn").fadeOut();
        $("#cancel_btn").fadeOut();
        $("#email-list").prop("disabled",true);
        $("#expert-desc").prop("disabled", true);
        location.reload();
    });
    $("#cbopt").click(function(){
       $("#confirm").fadeIn();

    });
    $("#cboptout").click(function(){
        $("#confirm_out").fadeIn();

    });
    $("#confirm").click(function(){
        $(".exp_opt_in").hide();
        $(".exp_opt_out").fadeIn();
        $("#cboptout").prop('checked',false);
        $("#confirm_out").hide();
    });
    $("#confirm_out").click(function(){
        $(".exp_opt_in").fadeIn();
        $(".exp_opt_out").hide();
        $("#cbopt").prop('checked',false);
        $("#confirm").hide();
    });
    $("#edit_expertise").click(function (e) {
        e.preventDefault();
       $("#explist").toggle();
    });
    $("#edit_rsca").click(function (e) {
        e.preventDefault();
        $("#rscalist").toggle();
    });
    $("#exp_cancel_btn").click(function () {
        $("#explist").toggle();
        $("#expert-results").fadeOut();
        $('#explist option').prop('selected',false);

    });

    $("#rsca_cancel_btn").click(function () {
        $("#rscalist").toggle();
        $("#upd_rsca").fadeOut();
    });
    $("#rsca_btn").click(function () {
        $("#upd_rsca").fadeIn();
        $("#rscalist").hide();
    });
    $("#change-content").click(function(){
        var divHtml = $("#rsca-currcontent").html();
        var editableText = $("<textarea />").addClass('edited-content').attr({'id':'revised-copy','tabindex':'0'});
        editableText.val(divHtml);
        if (editableText.val(divHtml) == 'No data found.'){
            $("#rsca-currcontent").attr("value", "");
        }
        $("#rsca-currcontent").replaceWith(editableText);
        editableText.focus();
        $("#profile_btn").fadeIn();
        $("#cancel_btn").fadeIn();



    });

    // Used to format phone number
function phoneFormatter() {
  $('#alt-phone').on('input', function() {
    var number = $(this).val().replace(/[^\d]/g, '')
    if (number.length == 7) {
      number = number.replace(/(\d{3})(\d{4})/, "$1-$2");
    } else if (number.length == 10) {
      number = number.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
    }
    $(this).val(number)
  });
};

$(phoneFormatter);




</script>   
<script>
    $("#profile_btn").on('click', function(e) {
        e.preventDefault();
        $("#upd_confirm").modal('show');
        $(".boxit").attr("aria-hidden","true");
        
        

    });


   $("#sub-cancel").click( function(){
        $.ajax({

            url: '<?php echo base_url("update_user/cancel_user_profile");?>',
            type: "GET",
            success: function () {
                location.reload();
                $("#edit_profile").focus();

            }
        });
    });
    $('#imgfile').change(function(){
        var file = $('#imgfile').val();
        file = file.substring(file.lastIndexOf("\\") +1, file.length);

        $('#subfile').val($('input[type=file]')[0].files[0].name);
        $("#browser").hide();
        $("#image_confirm").fadeIn().focus();
        



    });

    $('#uploadimage').submit( function( e ) {
        $.ajax( {
            url: '<?php echo base_url("upload/do_upload");?>',
            type: 'POST',
            data: new FormData($('#uploadimage')[0]),
            processData: false,
            contentType: false,
            success: function (data) {

                console.log(data);
                $("#newimage").html(data).fadeIn().delay(2000);

                $("#profileimg").attr('src', data);

            }
        } );
        e.preventDefault();

    });

    $("#srch").click(function (){
        $(this).removeClass("btn-primary");
        $(this).addClass("btn-success");
        $(this).attr('aria-checked','true');
        $("#unsrch").attr("aria-checked","false");
        if ($("#unsrch").hasClass("btn-success")){
            $("#unsrch").removeClass("btn-success");
            
        }
        if ($("#srchicon").hasClass("icon-check-empty")){
            $("#srchicon").removeClass("icon-check-empty");
            $("#srchicon").addClass("icon-check");

        }
        if ($("#unsrchicon").hasClass("icon-check")){
            $("#unsrchicon").removeClass("icon-check");
            $("#unsrchicon").addClass("icon-check-empty");

        }
        $("#searchopt").val("1");

        var opt = $("#searchopt").val();
        console.log(opt);


    });
    $("#unsrch").click(function (){
        $(this).removeClass("btn-primary");
        $(this).addClass("btn-success");
        $(this).attr('aria-checked','true');
        $("#srch").attr("aria-checked","false");
        if ($("#srch").hasClass("btn-success")){
            $("#srch").removeClass("btn-success");
            
        }
        if ($("#unsrchicon").hasClass("icon-check-empty")){
            $("#unsrchicon").removeClass("icon-check-empty");
            $("#unsrchicon").addClass("icon-check");

        }
        if ($("#srchicon").hasClass("icon-check")){
            $("#srchicon").removeClass("icon-check");
            $("#srchicon").addClass("icon-check-empty");

        }
        $("#searchopt").val("0");

        var opt = $("#searchopt").val();
        console.log(opt);

    });

    $("#upd_confirm").on('keydown', function ( e ) {
    var key = e.which || e.keyCode;
    if (key == 13) {
        setTimeout(function(){
        $("#suball").click(); // <----use the DOM click this way!!!
    },200);
}
    });
 

    $("#suball").click(function () {
        var opt = 0;
        if ($("#srch").hasClass("btn-success")){
            optin = 1;
        }
        if ($("#unsrch").hasClass("btn-success")){
            optin = 0;
            }
            $(".boxit").show();
            var form_data = {
                expdesc: $('#revised-copy').val(),
                title: $('#expert-title').val(),
                email: $('#email-list').val(),
                webpage: $('#expert-url').val(),
                altphone:$('#alt-phone').val(),
                subfile: $('#subfile').val(),
                division: $('#division').val(),
                searchopt: optin,
        }

        
        $.ajax({

            url: '<?php echo base_url("update_user/submit_user_profile");?>',
            type: "POST",
            dataType: 'html',
            data: form_data,
            resetForm: true,
            success: function (data) {
                $("#newimage").fadeOut();
                $("#profile-results").fadeOut();
                $("#expert-results").fadeOut();
                $("#sub-data").hide();
                $("#sub-data-submitted").fadeIn();
                $("#explist").toggle();
                console.log("SUCCESS");
                location.reload();
            }
        });

    });

    $("#close-help").click(function (){
        
    
        setTimeout(function(){
        $('#help').focus();
        },200);

    });
    $("#help").click(function (){
        
        setTimeout(function(){
        $('#pdata').focus();
        },200);
        
        });

   

</script>

</body>
</html>